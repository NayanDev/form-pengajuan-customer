<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomerController extends DefaultController
{
    protected $modelClass = Customer::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Customer';
        $this->generalUri = 'customer';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_multilink', 'btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Tanggal registrasi', 'column' => 'tanggal_registrasi', 'order' => true],
            ['name' => 'Status customer', 'column' => 'status_customer', 'order' => true],
            ['name' => 'Cabang pengajuan', 'column' => 'cabang_pengajuan', 'order' => true],
            ['name' => 'Nama customer', 'column' => 'nama_customer', 'order' => true],
            ['name' => 'Tipe customer', 'column' => 'tipe_customer', 'order' => true],
            // ['name' => 'Telepon', 'column' => 'telepon', 'order' => true],
            // ['name' => 'Alamat email', 'column' => 'alamat_email', 'order' => true],
            // ['name' => 'No ktp', 'column' => 'no_ktp', 'order' => true],
            ['name' => 'Alamat outlet', 'column' => 'alamat_outlet', 'order' => true],
            // ['name' => 'No fax', 'column' => 'no_fax', 'order' => true],
            ['name' => 'Nama pic', 'column' => 'nama_pic', 'order' => true],
            ['name' => 'Jabatan', 'column' => 'jabatan', 'order' => true],
            // ['name' => 'Alasan perubahan', 'column' => 'alasan_perubahan', 'order' => true],
            // ['name' => 'Izin operasional', 'column' => 'izin_operasional', 'order' => true],
            // ['name' => 'Masa berlaku izin operasional', 'column' => 'masa_berlaku_izin_operasional', 'order' => true],
            // ['name' => 'Sipa', 'column' => 'sipa', 'order' => true],
            // ['name' => 'Masa berlaku sipa', 'column' => 'masa_berlaku_sipa', 'order' => true],
            // ['name' => 'Cdob', 'column' => 'cdob', 'order' => true],
            // ['name' => 'Masa berlaku cdob', 'column' => 'masa_berlaku_cdob', 'order' => true],
            // ['name' => 'No npwp outlet', 'column' => 'no_npwp_outlet', 'order' => true],
            // ['name' => 'Nama npwp', 'column' => 'nama_npwp', 'order' => true],
            // ['name' => 'Alamat npwp', 'column' => 'alamat_npwp', 'order' => true],
            // ['name' => 'Id sales', 'column' => 'id_sales', 'order' => true],
            // ['name' => 'Gl akun piutang', 'column' => 'gl_akun_piutang', 'order' => true],
            // ['name' => 'Sumber dana', 'column' => 'sumber_dana', 'order' => true],
            // ['name' => 'Ttd apj', 'column' => 'ttd_apj', 'order' => true],
            // ['name' => 'Nama terang', 'column' => 'nama_terang', 'order' => true],
            // ['name' => 'Dokumen pendukung', 'column' => 'dokumen_pendukung', 'order' => true],
            // ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            // ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['tanggal_registrasi'],
            'headers' => [
                ['name' => 'Tanggal registrasi', 'column' => 'tanggal_registrasi'],
                ['name' => 'Status customer', 'column' => 'status_customer'],
                ['name' => 'Cabang pengajuan', 'column' => 'cabang_pengajuan'],
                ['name' => 'Tipe customer', 'column' => 'tipe_customer'],
                ['name' => 'Nama customer', 'column' => 'nama_customer'],
                ['name' => 'Telepon', 'column' => 'telepon'],
                ['name' => 'Alamat email', 'column' => 'alamat_email'],
                ['name' => 'No ktp', 'column' => 'no_ktp'],
                ['name' => 'Alamat outlet', 'column' => 'alamat_outlet'],
                ['name' => 'No fax', 'column' => 'no_fax'],
                ['name' => 'Nama pic', 'column' => 'nama_pic'],
                ['name' => 'Jabatan', 'column' => 'jabatan'],
                ['name' => 'Alasan perubahan', 'column' => 'alasan_perubahan'],
                ['name' => 'Izin operasional', 'column' => 'izin_operasional'],
                ['name' => 'Masa berlaku izin operasional', 'column' => 'masa_berlaku_izin_operasional'],
                ['name' => 'Sipa', 'column' => 'sipa'],
                ['name' => 'Masa berlaku sipa', 'column' => 'masa_berlaku_sipa'],
                ['name' => 'Cdob', 'column' => 'cdob'],
                ['name' => 'Masa berlaku cdob', 'column' => 'masa_berlaku_cdob'],
                ['name' => 'No npwp outlet', 'column' => 'no_npwp_outlet'],
                ['name' => 'Nama npwp', 'column' => 'nama_npwp'],
                ['name' => 'Alamat npwp', 'column' => 'alamat_npwp'],
                ['name' => 'Id sales', 'column' => 'id_sales'],
                ['name' => 'Gl akun piutang', 'column' => 'gl_akun_piutang'],
                ['name' => 'Sumber dana', 'column' => 'sumber_dana'],
                ['name' => 'Ttd apj', 'column' => 'ttd_apj'],
                ['name' => 'Nama terang', 'column' => 'nama_terang'],
                ['name' => 'Dokumen pendukung', 'column' => 'dokumen_pendukung'],
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $statusCustomer = [
            ['value' => 'Baru', 'text' => 'Baru'],
            ['value' => 'Perubahan', 'text' => 'Perubahan'],
        ];

        $cabangPengajuan = [
            ['value' => 'Pusat', 'text' => 'Pusat'],
            ['value' => 'Cabang Semarang', 'text' => 'Cabang Semarang'],
            ['value' => 'Cabang Makassar', 'text' => 'Cabang Makassar'],
            ['value' => 'Cabang Manado', 'text' => 'Cabang Manado'],
            ['value' => 'MBI', 'text' => 'MBI'],
        ];

        $tipeCustomer = [
            ['value' => 'H1', 'text' => 'H1'],
            ['value' => 'H2', 'text' => 'H2'],
            ['value' => 'H3', 'text' => 'H3'],
            ['value' => 'H4', 'text' => 'H4'],
            ['value' => 'H5', 'text' => 'H5'],
            ['value' => 'H6', 'text' => 'H6'],
            ['value' => 'H7', 'text' => 'H7'],
            ['value' => 'H8', 'text' => 'H8'],
            ['value' => 'H9', 'text' => 'H9'],
        ];

        $idSales = [
            ['value' => 'MDO-01 CLAUDIO STEFANUS', 'text' => 'MDO-01 CLAUDIO STEFANUS'],
            ['value' => 'MDO-02 IMANUEL PEFRIANDY', 'text' => 'MDO-02 IMANUEL PEFRIANDY'],
            ['value' => 'MDO-03 JODY CHRISTIAN', 'text' => 'MDO-03 JODY CHRISTIAN'],
            ['value' => 'MDO-04 NELVI WAHYUNINGSIH', 'text' => 'MDO-04 NELVI WAHYUNINGSIH'],
            ['value' => 'MDO-05 JIMMY YUSTINUS TANTANG', 'text' => 'MDO-05 JIMMY YUSTINUS TANTANG'],
            ['value' => 'MDO-06 HENDRY ROYKE SENGKEY', 'text' => 'MDO-06 HENDRY ROYKE SENGKEY'],
            ['value' => 'MDO-07 FEBRIANTO PS', 'text' => 'MDO-07 FEBRIANTO PS'],
            ['value' => 'MDO-08 BRIAN GOLAH PATRIKS LONGKUTOY', 'text' => 'MDO-08 BRIAN GOLAH PATRIKS LONGKUTOY'],
            ['value' => 'MDO-09 OFFICE MANADO', 'text' => 'MDO-09 OFFICE MANADO'],
        ];

        $glAkunPiutang = [
            ['value' => '1130001 PIUTANG REGULER', 'text' => '1130001 PIUTANG REGULER'],
            ['value' => '1130002 PIUTANG CABANG SEMARANG', 'text' => '1130001 PIUTANG CABANG SEMARANG'],
            ['value' => '1130003 PIUTANG CABANG MAKASSAR', 'text' => '1130001 PIUTANG CABANG MAKASSAR'],
            ['value' => '1130004 PIUTANG CABANG MANADO', 'text' => '1130001 PIUTANG CABANG MANADO'],
        ];

        $fields = [
            [
                'type' => 'datetime',
                'label' => 'Tanggal registrasi',
                'name' =>  'tanggal_registrasi',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('tanggal_registrasi', $id),
                'value' => (isset($edit)) ? $edit->tanggal_registrasi : ''
            ],
            [
                'type' => 'select',
                'label' => 'Status customer',
                'name' =>  'status_customer',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('status_customer', $id),
                'value' => (isset($edit)) ? $edit->status_customer : '',
                'options' => $statusCustomer,
            ],
            [
                'type' => 'select',
                'label' => 'Cabang pengajuan',
                'name' =>  'cabang_pengajuan',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('cabang_pengajuan', $id),
                'value' => (isset($edit)) ? $edit->cabang_pengajuan : '',
                'options' => $cabangPengajuan,
            ],
            [
                'type' => 'text',
                'label' => 'Nama customer',
                'name' =>  'nama_customer',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('nama_customer', $id),
                'value' => (isset($edit)) ? $edit->nama_customer : ''
            ],
            [
                'type' => 'text',
                'label' => 'Telepon',
                'name' =>  'telepon',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('telepon', $id),
                'value' => (isset($edit)) ? $edit->telepon : ''
            ],
            [
                'type' => 'text',
                'label' => 'Alamat email',
                'name' =>  'alamat_email',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('alamat_email', $id),
                'value' => (isset($edit)) ? $edit->alamat_email : ''
            ],
            [
                'type' => 'text',
                'label' => 'No ktp',
                'name' =>  'no_ktp',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('no_ktp', $id),
                'value' => (isset($edit)) ? $edit->no_ktp : ''
            ],
            [
                'type' => 'textarea',
                'label' => 'Alamat outlet',
                'name' =>  'alamat_outlet',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('alamat_outlet', $id),
                'value' => (isset($edit)) ? $edit->alamat_outlet : ''
            ],
            [
                'type' => 'select',
                'label' => 'Tipe customer',
                'name' =>  'tipe_customer',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('tipe_customer', $id),
                'value' => (isset($edit)) ? $edit->tipe_customer : '',
                'options' => $tipeCustomer,
            ],
            [
                'type' => 'text',
                'label' => 'No fax',
                'name' =>  'no_fax',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('no_fax', $id),
                'value' => (isset($edit)) ? $edit->no_fax : ''
            ],
            [
                'type' => 'text',
                'label' => 'Nama pic',
                'name' =>  'nama_pic',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('nama_pic', $id),
                'value' => (isset($edit)) ? $edit->nama_pic : ''
            ],
            [
                'type' => 'text',
                'label' => 'Jabatan',
                'name' =>  'jabatan',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('jabatan', $id),
                'value' => (isset($edit)) ? $edit->jabatan : ''
            ],
            [
                'type' => 'textarea',
                'label' => 'Alasan perubahan',
                'name' =>  'alasan_perubahan',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('alasan_perubahan', $id),
                'value' => (isset($edit)) ? $edit->alasan_perubahan : ''
            ],
            [
                'type' => 'text',
                'label' => 'Izin operasional',
                'name' =>  'izin_operasional',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('izin_operasional', $id),
                'value' => (isset($edit)) ? $edit->izin_operasional : ''
            ],
            [
                'type' => 'datetime',
                'label' => 'Masa berlaku izin operasional',
                'name' =>  'masa_berlaku_izin_operasional',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('masa_berlaku_izin_operasional', $id),
                'value' => (isset($edit)) ? $edit->masa_berlaku_izin_operasional : ''
            ],
            [
                'type' => 'text',
                'label' => 'Sipa',
                'name' =>  'sipa',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('sipa', $id),
                'value' => (isset($edit)) ? $edit->sipa : ''
            ],
            [
                'type' => 'datetime',
                'label' => 'Masa berlaku sipa',
                'name' =>  'masa_berlaku_sipa',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('masa_berlaku_sipa', $id),
                'value' => (isset($edit)) ? $edit->masa_berlaku_sipa : ''
            ],
            [
                'type' => 'text',
                'label' => 'Cdob',
                'name' =>  'cdob',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('cdob', $id),
                'value' => (isset($edit)) ? $edit->cdob : ''
            ],
            [
                'type' => 'datetime',
                'label' => 'Masa berlaku cdob',
                'name' =>  'masa_berlaku_cdob',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('masa_berlaku_cdob', $id),
                'value' => (isset($edit)) ? $edit->masa_berlaku_cdob : ''
            ],
            [
                'type' => 'text',
                'label' => 'No npwp outlet',
                'name' =>  'no_npwp_outlet',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('no_npwp_outlet', $id),
                'value' => (isset($edit)) ? $edit->no_npwp_outlet : ''
            ],
            [
                'type' => 'text',
                'label' => 'Nama npwp',
                'name' =>  'nama_npwp',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('nama_npwp', $id),
                'value' => (isset($edit)) ? $edit->nama_npwp : ''
            ],
            [
                'type' => 'textarea',
                'label' => 'Alamat npwp',
                'name' =>  'alamat_npwp',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('alamat_npwp', $id),
                'value' => (isset($edit)) ? $edit->alamat_npwp : ''
            ],
            [
                'type' => 'select',
                'label' => 'Id sales',
                'name' =>  'id_sales',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('id_sales', $id),
                'value' => (isset($edit)) ? $edit->id_sales : '',
                'options' => $idSales,
            ],
            [
                'type' => 'select',
                'label' => 'Gl akun piutang',
                'name' =>  'gl_akun_piutang',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('gl_akun_piutang', $id),
                'value' => (isset($edit)) ? $edit->gl_akun_piutang : '',
                'options' => $glAkunPiutang,
            ],
            [
                'type' => 'text',
                'label' => 'Nama terang',
                'name' =>  'nama_terang',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('nama_terang', $id),
                'value' => (isset($edit)) ? $edit->nama_terang : ''
            ],
            [
                'type' => 'text',
                'label' => 'Ttd apj',
                'name' =>  'ttd_apj',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('ttd_apj', $id),
                'value' => (isset($edit)) ? $edit->ttd_apj : ''
            ],
            [
                'type' => 'text',
                'label' => 'Dokumen pendukung',
                'name' =>  'dokumen_pendukung',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('dokumen_pendukung', $id),
                'value' => (isset($edit)) ? $edit->dokumen_pendukung : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Sumber dana',
                'name' =>  'sumber_dana',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('sumber_dana', $id),
                'value' => (isset($edit)) ? $edit->sumber_dana : ''
            ],
        ];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
    }


    protected function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'multilink';

        $eb = [];
        $data_columns = [];
        foreach ($this->tableHeaders as $key => $col) {
            if ($key > 0) {
                $data_columns[] = $col['column'];
            }
        }

        foreach ($this->actionButtons as $key => $ab) {
            if (in_array(str_replace("btn_", "", $ab), $permission)) {
                $eb[] = $ab;
            }
        }

        $dataQueries = $this->defaultDataQuery()->paginate(10);

        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }


    public function index()
    {
        $baseUrlExcel = route($this->generalUri . '.export-excel-default');
        $baseUrlPdf = route($this->generalUri . '.export-pdf-default');

        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' data-base-url='" . $baseUrlExcel . "' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='" . $baseUrlPdf . "' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.list_drawer_customer';
        if (isset($this->drawerLayout)) {
            $layout = $this->drawerLayout;
        }
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['headerLayout'] = $this->pageHeaderLayout;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi');
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'easyadmin::backend.idev.buttons.import_default',
            'backend.idev.buttons.multilink',
        ];
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        return view($layout, $data);
    }

    protected function pengajuanCustomer()
    {
        try {
        // Validasi input
        $validated = request()->validate([
            'tanggal_registrasi' => 'required|date',
            'status_customer' => 'required|in:baru,perubahan',
            'cabang_pengajuan' => 'required|string|max:100',
            'tipe_customer' => 'required|string',
            'nama_customer' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'no_ktp' => 'nullable|string|max:50',
            'no_fax' => 'nullable|string|max:50',
            'alamat_outlet' => 'nullable|string',
            'nama_pic' => 'nullable|string|max:100',
            'jabatan_pic' => 'nullable|string|max:100',
            'alasan_perubahan' => 'nullable|string',
            'izin_operasional' => 'nullable|string|max:100',
            'masa_berlaku_izin' => 'nullable|date',
            'sipa' => 'nullable|string|max:100',
            'masa_berlaku_sipa' => 'nullable|date',
            'cdob' => 'nullable|string|max:100',
            'masa_berlaku_cdob' => 'nullable|date',
            'no_npwp_outlet' => 'nullable|string|max:50',
            'nama_npwp' => 'nullable|string|max:100',
            'alamat_npwp' => 'nullable|string',
            'id_sales' => 'nullable|string|max:255',
            'gl_akun_piutang' => 'nullable|string|max:100',
            'nama_terang' => 'nullable|string|max:100',
            'ttd_apj' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf|max:3072', // max 3MB
            'grup' => 'nullable|string',
        ]);

        $userId = Auth::user()->id;

        // Handle upload dokumen
        $dokumenPath = null;
        if (request()->hasFile('dokumen_pendukung')) {
            $file = request()->file('dokumen_pendukung');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('dokumen'), $fileName);
            $dokumenPath = $fileName;
        }

        // Handle signature (ttd_apj) - convert base64 to image
        $ttdPath = null;
        if (!empty($validated['ttd_apj'])) {
            try {
                // Remove data:image/png;base64, prefix if exists
                $imageData = $validated['ttd_apj'];
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                } else {
                    $type = 'png'; // default
                }
                
                $imageData = base64_decode($imageData);
                
                if ($imageData !== false) {
                    // Create unique filename
                    $ttdFileName = 'ttd_' . time() . '_' . uniqid() . '.' . $type;
                    
                    // Ensure directory exists
                    if (!file_exists(public_path('ttd'))) {
                        mkdir(public_path('ttd'), 0755, true);
                    }
                    
                    // Save the image
                    file_put_contents(public_path('ttd/' . $ttdFileName), $imageData);
                    $ttdPath = $ttdFileName;
                }
            } catch (\Exception $e) {
                // Log error but continue with null ttd_apj
                Log::warning('Failed to save signature: ' . $e->getMessage());
            }
        }

        // Mapping field name dari form ke database
        $customerData = [
            'tanggal_registrasi' => $validated['tanggal_registrasi'],
            'status_customer' => ucfirst($validated['status_customer']), // Baru atau Perubahan
            'cabang_pengajuan' => $validated['cabang_pengajuan'], // Default atau bisa diambil dari form
            'tipe_customer' => $validated['tipe_customer'],
            'nama_customer' => $validated['nama_customer'] ?? null,
            'telepon' => $validated['telepon'] ?? null,
            'alamat_email' => $validated['email'] ?? null,
            'no_ktp' => $validated['no_ktp'] ?? null,
            'alamat_outlet' => $validated['alamat_outlet'] ?? null,
            'no_fax' => $validated['no_fax'] ?? null,
            'nama_pic' => $validated['nama_pic'] ?? null,
            'jabatan' => $validated['jabatan_pic'] ?? null,
            'alasan_perubahan' => $validated['alasan_perubahan'] ?? null,
            'izin_operasional' => $validated['izin_operasional'] ?? null,
            'masa_berlaku_izin_operasional' => $validated['masa_berlaku_izin'] ?? null,
            'sipa' => $validated['sipa'] ?? null,
            'masa_berlaku_sipa' => $validated['masa_berlaku_sipa'] ?? null,
            'cdob' => $validated['cdob'] ?? null,
            'masa_berlaku_cdob' => $validated['masa_berlaku_cdob'] ?? null,
            'no_npwp_outlet' => $validated['no_npwp_outlet'] ?? null,
            'nama_npwp' => $validated['nama_npwp'] ?? null,
            'alamat_npwp' => $validated['alamat_npwp'] ?? null,
            'id_sales' => $validated['id_sales'] ?? null,
            'gl_akun_piutang' => $validated['gl_akun_piutang'] ?? null,
            'nama_terang' => $validated['nama_terang'] ?? null,
            'ttd_apj' => $ttdPath,
            'user_id' => $userId,
            'dokumen_pendukung' => $dokumenPath,
            'sumber_dana' => $validated['grup'] ?? null, // Menyimpan grup ke sumber_dana
        ];

        // Simpan ke database
        $customer = Customer::create($customerData);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan customer berhasil disimpan!',
            'data' => $customer
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
    }


    protected function generatePDF()
    {
        $customerId = request('customer_id');
        if (!$customerId) {
            abort(403, 'Customer Not Found.');
        }

        $customer = Customer::where('id', $customerId)->first();

        $data = [
            'customer' => $customer,
        ];

        $pdf = PDF::loadView('pdf.pengajuan-customer', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Certification" . ($request->year ?? date('Y')) . ".pdf");
    }

    protected function formTransfer()
    {
        $customerId = request('customer_id');
        if (!$customerId) {
            abort(403, 'Customer Not Found.');
        }

        $customer = Customer::where('id', $customerId)->first();

        $data = [
            'customer' => $customer,
        ];

        return view('backend.idev.form-transfer', $data);
    }


    protected function defaultDataQuery()
    {
        $user = Auth::user()->role->name;
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }

        $dataQueries = Customer::leftjoin('users', 'users.id', '=', 'customers.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('customers.tanggal_registrasi', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.status_customer', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.cabang_pengajuan', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.nama_customer', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.tipe_customer', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.alamat_outlet', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.nama_pic', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('customers.jabatan', 'LIKE', '%' . $orThose . '%');
            });

        // Cek role user
        if ( $user == 'apj') {
            $dataQueries = $dataQueries->where('customers.user_id', Auth::user()->id);
        }

        $dataQueries = $dataQueries->orderBy($orderBy, $orderState)
            ->select('customers.*');

        return $dataQueries;
    }
}
