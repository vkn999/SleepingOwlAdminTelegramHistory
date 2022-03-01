<?php

namespace App\Exports;

/**
  * https://github.com/Maatwebsite/Laravel-Excel
  * https://docs.laravel-excel.com/3.1/getting-started/installation.html
  * https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Style/NumberFormat.html
  */

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

//
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class StockExport implements FromCollection, WithColumnFormatting, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{

  use Importable, RegistersEventListeners;

  protected $collection;

  public function __construct($collection) {
    $this->collection = $collection;
  }

  public function headings(): array {
    return [
      '№',  // пустая -A
      'Дата создания товара', //товара  -B
      '# заявки', // -C
      '# товара', // -D
      'Наименование товара в заявке', // -E
      'Цвет / размер',  // -F
      'НАШ', //пустая   // -G
      'Цвет / размер склада', // -H
      '# товара склада',      // -I
      'Менеджер товара',      // -J
      'Комментарий к заявке', // пустая // -K
      'Статус',   // -L
      'Дата продажи', // -M
      'Дата создания на складе',  // -N

      // 'Дата ухода со склада',
      // 'Менеджер ухода',
    ];
  }

  public function registerEvents(): array {
    return [
      AfterSheet::class => function(AfterSheet $event) {
        $event->sheet->getDelegate()
          ->getRowDimension('1')->setRowHeight(30);

        $event->sheet->getDelegate()
          ->freezePane('A2', 'A2');

        $event->sheet->getDelegate()
          ->setAutoFilter('A1:N1')
          ->getStyle('A1:H1')
          ->getAlignment()
          ->setHorizontal('center')
          ->setVertical('top');

        $event->sheet->getDelegate()
          ->setAutoFilter('A1:N1')
          ->getStyle('A1:N1')
          ->getFont()
          ->setBold(true);

      }
    ];
  }

  public function map($stock): array {
    // $date_sell_product = '';

    return [
      $stock['id'],
      Date::dateTimeToExcel($stock['product_created_at']),
      $stock['order_id'],
      $stock['product_id'],
      $stock['title'],
      $stock['color_size'],
      $stock['our'],
      $stock['color_size_stock'],
      $stock['stock_id'],
      $stock['manager_product'],
      $stock['comment'],
      $stock['status'],
      $stock['date_sell_product'],
      Date::dateTimeToExcel($stock['created_at']),
    ];
  }

  public function columnFormats(): array {
    return [
      'A' => NumberFormat::FORMAT_NUMBER, //id
      'B' => NumberFormat::FORMAT_DATE_XLSX16, //product_created_at
      'C' => NumberFormat::FORMAT_NUMBER, //order_id
      'D' => NumberFormat::FORMAT_NUMBER, //product_id
      'E' => NumberFormat::FORMAT_TEXT, //title
      'F' => NumberFormat::FORMAT_TEXT, //color_size
      'G' => NumberFormat::FORMAT_TEXT, //our
      'H' => NumberFormat::FORMAT_TEXT, //color_size_stock
      'I' => NumberFormat::FORMAT_NUMBER, //stock_id
      'J' => NumberFormat::FORMAT_TEXT, //manager_product
      'K' => NumberFormat::FORMAT_TEXT, //comment
      'L' => NumberFormat::FORMAT_TEXT, //status
      'M' => NumberFormat::FORMAT_DATE_XLSX16, //date_sell_product
      'N' => NumberFormat::FORMAT_DATE_XLSX16, //created_at
    ];
  }

  public function collection() {
    $stocks = $this->collection->transform(function($item, $key) {
      // dd($item, $key);
      return [
        'id' => $key + 1,
        'product_created_at' => $item->products->first()->created_at,
        'order_id' => $item->products->first()->order_id,
        'product_id' => $item->product_id,
        'title' => $item->products->first()->title,
        'color_size' => $item->products->first()->color . ' / ' . $item->products->first()->size,
        'our' => '',
        'color_size_stock' => $item->color . ' / ' . $item->size,
        'stock_id' => $item->id,
        'manager_product' => $item->products->first()->managers->name,
        'comment' => '',
        'status' => $item->products->first()->status_products->name,
        'date_sell_product' => $item->products->first()->sell_at,
        'created_at' => $item->created_at,
      ];
    });

    return $stocks;
  }

}
