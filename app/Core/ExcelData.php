<?php

namespace App\Core;

use Maatwebsite\Excel\Facades\Excel;

class ExcelData
{
    public $data;
    public $col_headers;
    public $title;
    public $creator;
    public $company;
    public $blade_name;
    protected $file_name;
    protected $file_path;
    protected $file_full_path;
    public $excel_instance;

    public function __construct($data, $col_headers, $file_name, $relative_path = '', $full_path = '')
    {
        $this->data = $data;
        $this->col_headers = $col_headers;
        $this->file_name = $file_name;
        $this->file_path = $relative_path;
        $this->file_full_path = $full_path;
    }

    public function setFileName($name)
    {
        $this->file_name = $name;
    }

    public function setFilePath($relative_path)
    {
        $this->file_path = $relative_path;
    }

    public function setFileFullPath($full_path)
    {
        $this->file_full_path = $full_path;
    }

    public function createAtOnce($description = '')
    {
        Excel::create('Estado de Cuenta', function ($excel) use ($description) {
            if ($this->title) {
                $excel->setTitle($this->title);
            }

            if ($this->creator) {
                $excel->setCreator($this->creator);
            }

            if ($this->company) {
                $this->setCompany($this->company);
            }

            if ($description) {
                $excel->setDescription($description);
            }

            $excel->sheet('New sheet', function ($sheet) {
                $sheet->loadView('folder.view');
            });

            $excel->sheet('Default sheet', function ($sheet) {
                foreach ($this->data as $key => $item) {
                    $sheet->appendRow($item);
                }

                //General Headers and its styles
                $sheet->prependRow(1, $this->col_headers);
            });
        })->store('xlsx', false, true);
    }

    public function createFromBlade($blade_name)
    {
        $this->blade_name = $blade_name;

        $this->excel_instance = Excel::create($this->file_name, function ($excel) {
            if ($this->title) {
                $excel->setTitle($this->title);
            }

            if ($this->creator) {
                $excel->setCreator($this->creator);
            }

            if ($this->company) {
                $this->setCompany($this->company);
            }

            $excel->sheet('New sheet', function ($sheet) {
                $sheet->loadView($this->blade_name, $this->data);
            });
        });

        return $this->excel_instance;
    }

    public function downloadExcelFile()
    {
        $this->excel_instance->download('xlsx');
    }

    public function saveExcelFile()
    {
        $this->excel_instance->save('xlsx', $this->file_path);
    }
}
