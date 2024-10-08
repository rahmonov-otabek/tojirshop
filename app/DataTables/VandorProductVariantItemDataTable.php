<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VandorProductVariantItemDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($query){ 
            $editBtn = "<a href='".route('vendor.product-variant-item.edit', $query->id)."' class='btn btn-primary'>
            <i class='far fa-edit'></i> </a>";
            $deleteBtn = "<a href='".route('vendor.product-variant-item.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'>
            <i class='far fa-trash-alt'></i> </a>";
            
            return $editBtn.$deleteBtn;
        }) 
        ->addColumn('status', function($query){
            $active = '<i class="badge bg-success">Active</i>';
            $inactive = '<i class="badge bg-danger">Inactive</i>';
            if($query->status == 1){
                return $active;
            }else{
                return $inactive;
            }
        }) 
        ->addColumn('variant_name', function($query){
            return $query->productVariant->name;
        }) 
        ->addColumn('is_default', function($query){ 
            if($query->is_default == 1){
                return '<i class="badge bg-success">default</i>';
            }else{
                return '<i class="badge bg-danger">no</i>';
            }
        }) 
        ->rawColumns(['action', 'status', 'is_default'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id', request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vandorproductvariantitem-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'), 
            Column::make('name'),  
            Column::make('variant_name'), 
            Column::make('price'), 
            Column::make('is_default'), 
            Column::make('status'), 
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VandorProductVariantItem_' . date('YmdHis');
    }
}
