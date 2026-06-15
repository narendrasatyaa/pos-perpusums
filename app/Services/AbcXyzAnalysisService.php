<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AbcXyzAnalysisService
{
    /**
     * Calculate ABC-XYZ classifications for all active products.
     *
     * @param string $startDate 'Y-m-d H:i:s'
     * @param string $endDate 'Y-m-d H:i:s'
     * @return array Array of [product_id => [abc => 'A|B|C', xyz => 'X|Y|Z', cv => float, revenue => int, quantity => int]]
     */
    public function calculate(string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end);

        // Define intervals for XYZ Analysis
        // If the date range is very short (<= 14 days), we analyze by day.
        // Otherwise, we analyze by week (7-day intervals).
        $intervalDays = ($days <= 14) ? 1 : 7;
        
        // Generate interval boundary dates
        $intervals = [];
        $tempStart = $start->copy();
        while ($tempStart->lt($end)) {
            $tempEnd = $tempStart->copy()->addDays($intervalDays);
            if ($tempEnd->gt($end)) {
                $tempEnd = $end->copy();
            }
            $intervals[] = [
                'start' => $tempStart->copy(),
                'end' => $tempEnd->copy(),
            ];
            $tempStart->addDays($intervalDays);
        }
        $intervalCount = count($intervals);

        // Fetch total revenue and total quantity sold per product in the period
        $salesData = DB::table('transaction_items')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.status', 'paid')
            ->whereBetween('transactions.paid_at', [$startDate, $endDate])
            ->select('transaction_items.product_id', 
                DB::raw('SUM(transaction_items.subtotal) as total_revenue'),
                DB::raw('SUM(transaction_items.quantity) as total_quantity')
            )
            ->groupBy('transaction_items.product_id')
            ->get()
            ->keyBy('product_id');

        // Fetch transaction items with dates for XYZ analysis
        $rawSalesByDate = DB::table('transaction_items')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.status', 'paid')
            ->whereBetween('transactions.paid_at', [$startDate, $endDate])
            ->select('transaction_items.product_id', 'transaction_items.quantity', 'transactions.paid_at')
            ->get();

        // Group quantities by product and interval
        $productIntervalQuantities = [];
        foreach ($rawSalesByDate as $sale) {
            $paidAt = Carbon::parse($sale->paid_at);
            $intervalIndex = null;
            
            // Find which interval this sale belongs to
            foreach ($intervals as $index => $interval) {
                if ($paidAt->greaterThanOrEqualTo($interval['start']) && $paidAt->lessThanOrEqualTo($interval['end'])) {
                    $intervalIndex = $index;
                    break;
                }
            }

            if ($intervalIndex !== null) {
                $productId = $sale->product_id;
                if (!isset($productIntervalQuantities[$productId])) {
                    $productIntervalQuantities[$productId] = array_fill(0, $intervalCount, 0);
                }
                $productIntervalQuantities[$productId][$intervalIndex] += $sale->quantity;
            }
        }

        // Fetch all products (including those with 0 sales)
        $allProducts = Product::whereNull('deleted_at')->get();
        
        $analysisResult = [];
        
        // 1. Calculate ABC (Revenue contribution)
        // Sort products by revenue descending
        $productsWithRevenue = [];
        foreach ($allProducts as $product) {
            $pId = (string) $product->id;
            $revenue = isset($salesData[$pId]) ? (int) $salesData[$pId]->total_revenue : 0;
            $quantity = isset($salesData[$pId]) ? (int) $salesData[$pId]->total_quantity : 0;
            
            $productsWithRevenue[] = [
                'id' => $pId,
                'revenue' => $revenue,
                'quantity' => $quantity,
            ];
        }

        usort($productsWithRevenue, function ($a, $b) {
            return $b['revenue'] <=> $a['revenue'];
        });

        $totalStoreRevenue = array_sum(array_column($productsWithRevenue, 'revenue'));
        $runningSum = 0;

        foreach ($productsWithRevenue as $pData) {
            $pId = $pData['id'];
            $revenue = $pData['revenue'];
            
            $abc = 'C'; // Default
            if ($totalStoreRevenue > 0 && $revenue > 0) {
                $runningSum += $revenue;
                $cumulativeShare = ($runningSum / $totalStoreRevenue) * 100;
                
                if ($cumulativeShare <= 80.001) {
                    $abc = 'A';
                } elseif ($cumulativeShare <= 95.001) {
                    $abc = 'B';
                } else {
                    $abc = 'C';
                }
            } else {
                $abc = 'C';
            }

            // 2. Calculate XYZ (Volatility of demand)
            $xyz = 'Z'; // Default for no sales
            $cv = 999.0; // High value for zero/unstable sales
            
            if (isset($productIntervalQuantities[$pId]) && $intervalCount > 0) {
                $quantities = $productIntervalQuantities[$pId];
                
                // If the product had zero sales in some intervals, we explicitly count them as 0
                // Calculate mean (average)
                $mean = array_sum($quantities) / $intervalCount;
                
                if ($mean > 0) {
                    // Calculate standard deviation
                    $varianceSum = 0;
                    foreach ($quantities as $q) {
                        $varianceSum += pow($q - $mean, 2);
                    }
                    $stdDev = sqrt($varianceSum / $intervalCount);
                    
                    // Calculate Coefficient of Variation (CV)
                    $cv = $stdDev / $mean;
                    
                    // Categorize XYZ
                    if ($cv <= 0.20) {
                        $xyz = 'X';
                    } elseif ($cv <= 0.50) {
                        $xyz = 'Y';
                    } else {
                        $xyz = 'Z';
                    }
                }
            }

            $analysisResult[$pId] = [
                'abc' => $abc,
                'xyz' => $xyz,
                'cv' => $cv,
                'revenue' => $revenue,
                'quantity' => $pData['quantity'],
            ];
        }

        return $analysisResult;
    }
}
