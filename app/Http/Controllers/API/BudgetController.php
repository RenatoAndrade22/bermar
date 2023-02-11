<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\BudgetItem;

class BudgetController extends Controller
{

    public function show($id)
    {
        $budget = Budget::query()->where('warranty_id', $id)->first();

        $budget->budgetItems = collect($budget->budgetItems)->map(function ($item) {
            return [
                'id'    =>  $item['warranty_product_id'],
                'price' =>  $item['price'],
                'name'  =>  $item['warrantyProduct']['name'],
            ];
        });
        
        return [
            'budget_items' => isset($budget->budgetItems) ? $budget->budgetItems : null,
            'description' => isset($budget->description) ? $budget->description : null
        ];
    }

    public function store(Request $request)
    {

        $budget = Budget::query()
                    ->where('warranty_id', $request->get('warranty_id'))
                    ->firstOrNew();
       
        $budget->description = $request->get('description');
        $budget->warranty_id = $request->get('warranty_id');
        $budget->saveOrFail();

        //verifica se existe produtos desse orçamento, caso exista exclui.
        
        $products = BudgetItem::query()
            ->where('budget_id', $budget->id)
            ->delete();
    
        foreach($request->get('products') as $product){
            $budgetItem = new BudgetItem();
            $budgetItem->budget_id = $budget->id;
            $budgetItem->warranty_product_id = $product['id'];
            $budgetItem->price = $product['price'];
            $budgetItem->saveOrFail();
        }

        return $budget;

    }

}
