<?php

namespace App\Http\Controllers;

use App\Models\ProductSuggestion;
use Exception;

class ProductSuggestionController extends Controller
{
    public function index()
    {
        $category_id = (int) request()->query('category_id');
        $search_term = (string) request()->query('search_term');

        try {
            if (!$category_id) {
                $query = ProductSuggestion::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search_term) . '%']);
            } else {
                $query = ProductSuggestion::where('product_category_id', $category_id)
                    ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search_term) . '%']);
            }

            $suggestions = $query->orderBy('name', 'asc');
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível encontrar sugestões de produtos. Por favor, tente novamente mais tarde.'], 500);
        }

        return response()->json(['response' => $suggestions->get()], 200);
    }
}
