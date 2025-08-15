<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf as PdfWriter;


class EventReportController extends Controller
{
    /**
     * Menampilkan form laporan dengan data semua event.
     */
    public function index()
    {
        $data['judul'] = "Laporan Event";
        $data['data_event'] = EventModel::orderBy('tgl_awal', 'asc')->paginate(20);
        return view('formReport', $data);
    }

   public function filter(Request $request)
{
    $tanggal = $request->input('tanggal'); // format: yyyy-mm
    $search = $request->input('search');

    $query = EventModel::query();

    // Filter berdasarkan bulan & tahun dari field tgl_awal
    if ($tanggal) {
        [$year, $month] = explode('-', $tanggal);
        $query->whereYear('tgl_awal', $year)
              ->whereMonth('tgl_awal', $month);
    }

    // Filter berdasarkan pencarian
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
              ->orWhere('bagian', 'like', "%$search%")
              ->orWhere('unit_usaha', 'like', "%$search%")
              ->orWhere('judul_pelatihan', 'like', "%$search%")
              ->orWhere('jenis_pelatihan', 'like', "%$search%")
              ->orWhere('lokasi_pelatihan', 'like', "%$search%")
              ->orWhere('metode_pelatihan', 'like', "%$search%")
              ->orWhere('penyelenggara', 'like', "%$search%");
        });
    }

    $data_event = $query->orderBy('tgl_awal', 'asc')->paginate(20);

    return view('formReport', [
        'data_event' => $data_event,
        'bulan' => $month ?? null,
        'tahun' => $year ?? null
    ]);
}

    public function exportExcel(Request $request)
{
    $tanggal = $request->query('tanggal');
    $search = $request->query('search');

    $query = EventModel::query();

    if ($tanggal) {
        [$year, $month] = explode('-', $tanggal);
        $query->whereYear('tgl_awal', $year)
              ->whereMonth('tgl_awal', $month);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
                ->orWhere('bagian', 'like', "%$search%")
                ->orWhere('unit_usaha', 'like', "%$search%")
                ->orWhere('judul_pelatihan', 'like', "%$search%")
                ->orWhere('jenis_pelatihan', 'like', "%$search%")
                ->orWhere('lokasi_pelatihan', 'like', "%$search%")
                ->orWhere('metode_pelatihan', 'like', "%$search%")
                ->orWhere('penyelenggara', 'like', "%$search%");
        });
    }

    $data = $query->get();

    if ($data->isEmpty()) {
        return redirect()->route('report.index')->with('success', 'Tidak ada data untuk diekspor.');
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Logo
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath(public_path('images/logo_ptpn4.png'));
    $drawing->setHeight(80);
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(5);
    $drawing->setOffsetY(5);
    $drawing->setWorksheet($sheet);

    // Judul Kop Surat
    $sheet->mergeCells('B1:N1');
    $sheet->setCellValue('B1', 'Laporan Peserta Pelatihan');
    $sheet->mergeCells('B2:N2');
    $sheet->setCellValue('B2', 'PT Perkebunan Nusantara IV Regional IV');

    $sheet->getStyle('B1:B2')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ]);

    // Garis Hitam Tebal
    $sheet->getStyle('A3:N3')->applyFromArray([
        'borders' => [
            'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '000000']],
        ],
    ]);

    // Tanggal Laporan di bawah kop, kanan
    $tanggalLaporan = Carbon::now()->locale('id')->isoFormat('D MMMM Y');
    $sheet->mergeCells('K4:N4');
    $sheet->setCellValue('K4', 'Tanggal: ' . $tanggalLaporan);
    $sheet->getStyle('K4')->applyFromArray([
        'font' => ['italic' => true, 'size' => 11],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
    ]);

    // Header Tabel
    $headers = [
        'No', 'NIK', 'Nama', 'Jabatan', 'Bagian', 'Unit Usaha', 'Tanggal Pelatihan',
        'Judul Pelatihan', 'Metode', 'Lokasi', 'Jenis', 'Penyelenggara', 'Biaya'
    ];
    $sheet->fromArray($headers, null, 'A6');

    // Style Header
    $sheet->getStyle('A6:M6')->applyFromArray([
        'font' => ['bold' => true],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ]);

    // Isi Data
    $row = 7;
    foreach ($data as $index => $event) {
        $tanggalPelatihan = Carbon::parse($event->tgl_awal)->locale('id')->isoFormat('D MMMM Y') . ' - ' .
                            Carbon::parse($event->tgl_akhir)->locale('id')->isoFormat('D MMMM Y');

        $sheet->fromArray([
            $index + 1,
            $event->nik,
            $event->nama,
            $event->jabatan,
            $event->bagian,
            $event->unit_usaha,
            $tanggalPelatihan,
            $event->judul_pelatihan,
            $event->metode_pelatihan,
            $event->lokasi_pelatihan,
            $event->jenis_pelatihan,
            $event->penyelenggara,
            $event->biaya
        ], null, 'A' . $row);

        $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            'font' => ['size' => 10],
        ]);

        $row++;
    }

    // Autosize semua kolom
    foreach (range('A', 'M') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Tanda Tangan
    $row += 2;
    $tanggalSekarang = Carbon::now()->locale('id')->isoFormat('D MMMM Y');

    // Baris "Jambi, ..."
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'Jambi, ' . $tanggalSekarang);
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => ['size' => 11],
    ]);

    // Spasi kosong
    $row += 4;

    // Baris Nama
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'Heri Kurniawan');
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => [
            'bold' => true,
            'underline' => true,
            'size' => 11,
        ],
    ]);

    // Baris NIK
    $row++;
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'NIK: 606134521');
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => ['size' => 10],
    ]);

    // Simpan dan unduh
    $fileName = 'Laporan_Event_' . now()->format('Ymd_His') . '.xlsx';
    $filePath = public_path($fileName);
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    return response()->download($filePath)->deleteFileAfterSend(true);
}


    public function exportPDF(Request $request)
{
    $tanggal = $request->query('tanggal');
    $search = $request->query('search');

    $query = EventModel::query();

    if ($tanggal) {
        [$year, $month] = explode('-', $tanggal);
        $query->whereYear('tgl_awal', $year)
              ->whereMonth('tgl_awal', $month);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
              ->orWhere('bagian', 'like', "%$search%")
              ->orWhere('unit_usaha', 'like', "%$search%")
              ->orWhere('judul_pelatihan', 'like', "%$search%")
              ->orWhere('jenis_pelatihan', 'like', "%$search%")
              ->orWhere('lokasi_pelatihan', 'like', "%$search%")
              ->orWhere('metode_pelatihan', 'like', "%$search%")
              ->orWhere('penyelenggara', 'like', "%$search%");
        });
    }

    $data = $query->get();

    if ($data->isEmpty()) {
        return redirect()->route('report.index')->with('success', 'Tidak ada data untuk dicetak.');
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getDefaultStyle()->getFont()
    ->setName('Times New Roman') 
    ->setSize(11);

    // Setup halaman
    $pageSetup = $sheet->getPageSetup();
    $pageSetup->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    $pageSetup->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
    $sheet->getPageMargins()->setTop(0.2);
    $sheet->getPageMargins()->setBottom(0.2);
    $sheet->getPageMargins()->setLeft(0.2);
    $sheet->getPageMargins()->setRight(0.2);
    $pageSetup->setFitToWidth(1);
    $pageSetup->setFitToHeight(0);

    // Tambahkan Logo
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath(public_path('images/logo_ptpn4.png'));
    $drawing->setHeight(110); // Sesuaikan ukuran
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(5);
    $drawing->setOffsetY(5);
    $drawing->setWorksheet($sheet);

    // Judul Kop Surat
    $sheet->mergeCells('B1:M1');
    $sheet->setCellValue('B1', 'Laporan Peserta Pelatihan');
    $sheet->mergeCells('B2:M2');
    $sheet->setCellValue('B2', 'PT. Perkebunan Nusantara IV Regional IV');

    $sheet->getStyle('B1:B2')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);

    // Garis Hitam Tebal setelah Kop
    $sheet->getStyle('A3:M3')->applyFromArray([
        'borders' => [
            'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 'color' => ['rgb' => '000000']],
        ],
    ]);

    // Tanggal Laporan di bawah garis - kanan
    $tanggalLaporan = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
    $sheet->mergeCells('K4:M4');
    $sheet->setCellValue('K4', 'Tanggal: ' . $tanggalLaporan);
    $sheet->getStyle('K4')->applyFromArray([
        'font' => ['italic' => true, 'size' => 11],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
    ]);

    // Header Tabel
    $headers = [
        'No', 'NIK', 'Nama', 'Jabatan', 'Bagian', 'Unit Usaha',
        'Tanggal Pelatihan', 'Judul Pelatihan', 'Metode', 'Lokasi', 'Jenis', 'Penyelenggara', 'Biaya'
    ];
    $sheet->fromArray($headers, null, 'A6');

    // Style Header Tabel
    $sheet->getStyle('A6:M6')->applyFromArray([
        'font' => ['bold' => true, 'size' => 12],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ]);

    // Isi Data Tabel
    $row = 7;
    foreach ($data as $index => $event) {
        $tanggalPelatihan = Carbon::parse($event->tgl_awal)->format('d/m/Y') . ' - ' . Carbon::parse($event->tgl_akhir)->format('d/m/Y');

        $sheet->fromArray([
            $index + 1,
            $event->nik,
            $event->nama,
            $event->jabatan,
            $event->bagian,
            $event->unit_usaha,
            $tanggalPelatihan,
            $event->judul_pelatihan,
            $event->metode_pelatihan,
            $event->lokasi_pelatihan,
            $event->jenis_pelatihan,
            $event->penyelenggara,
            $event->biaya
        ], null, 'A' . $row);

        $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'font' => ['size' => 11],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        $row++;
    }

    // Setelah selesai isi data dan sebelum export PDF:
    $sheet->getColumnDimension('A')->setAutoSize(false);
    $sheet->getColumnDimension('A')->setWidth(4); // Kecil

    // Kolom lain auto size
    foreach (range('B', 'M') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
    $sheet->getStyle($col . '6:' . $col . ($row - 1))
          ->getAlignment()
          ->setWrapText(true); // Bungkus teks agar tidak dorong kolom A
}

    // Style kolom A biar rapi
    $sheet->getStyle('A6:A' . ($row - 1))->applyFromArray([
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'font' => ['size' => 11],
    ]);


    // ======================
    // Tanda Tangan Bawah
    // ======================
    $row += 2;
    $tanggalSekarang = Carbon::now()->locale('id')->isoFormat('D MMMM Y');

    // Baris Tanggal: "Jambi, [tanggal]"
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'Jambi, ' . $tanggalSekarang);
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => ['size' => 11],
    ]);

    // Spasi kosong sebelum nama
    $row += 4;

    // Baris Nama: "Heri Kurniawan" dengan underline (font)
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'Heri Kurniawan');
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => [
            'bold' => true,
            'size' => 11,
            'underline' => true, // <<== INI penting!
        ],
    ]);

    // Baris NIK: "NIK: 606134521"
    $row++;
    $sheet->mergeCells("J{$row}:M{$row}");
    $sheet->setCellValue("J{$row}", 'NIK: 606134521');
    $sheet->getStyle("J{$row}")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        'font' => ['size' => 11],
    ]);

    // Export PDF
    $fileName = 'Laporan_Peserta_Pelatihan_' . now()->format('Ymd_His') . '.pdf';
    $tempPath = storage_path('app/public/' . $fileName);

    $writer = new PdfWriter($spreadsheet);
    $writer->save($tempPath);


    return response()->download($tempPath)->deleteFileAfterSend(true);
}


}
