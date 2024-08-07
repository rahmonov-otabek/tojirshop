<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductVariantDataTable extends DataTable
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
            $variantItems = "<a href='".route('admin.product-variant-item.index', ['productId' => request()->product, 'variantId' => $query->id])."' class='btn btn-info mr-2'>
            <i class='far fa-edit'></i> Variant Items</a>";
            $editBtn = "<a href='".route('admin.product-variant.edit', $query->id)."' class='btn btn-primary'>
            <i class='far fa-edit'></i> </a>";
            $deleteBtn = "<a href='".route('admin.product-variant.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'>
            <i class='far fa-trash-alt'></i> </a>";
             
            return $variantItems.$editBtn.$deleteBtn;
        }) 
        ->addColumn('status', function($query){
            $active = '<i class="badge badge-success">Active</i>';
            $inactive = '<i class="badge badge-danger">Inactive</i>';
            if($query->status == 1){
                return $active;
            }else{
                return $inactive;
            }
        }) 
        ->rawColumns(['action', 'status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->where('product_id', request()->product)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productvariant-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0,'asc')
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
            Column::make('status'), 
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(300)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductVariant_' . date('YmdHis');
    }
}
