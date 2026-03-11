@php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

  

       $sheet->SetCellValue('A1', 'S. No.');
       $sheet->SetCellValue('B1', 'Membership ID');
       $sheet->SetCellValue('C1', 'Name');
       $sheet->SetCellValue('D1', 'Sponsor ID');
       $sheet->SetCellValue('E1', 'Sponsor Name');
        //$sheet->SetCellValue('F1', 'Reward Designation');
       $sheet->SetCellValue('F1', 'Mobile No.');
       $sheet->SetCellValue('G1', 'PAN No.');
       $sheet->SetCellValue('H1', 'Aadhaar No.');
       $sheet->SetCellValue('I1', 'Email');
       $sheet->SetCellValue('J1', 'Pincode');
       $sheet->SetCellValue('K1', 'Bank Name');
       $sheet->SetCellValue('L1', 'Account Holder Number');
       $sheet->SetCellValue('M1', 'Bank Swift/IFSC Code');
       $sheet->SetCellValue('N1', 'Account Name');
       $sheet->SetCellValue('O1', 'Status');
       $sheet->SetCellValue('P1', 'Date');





        $row = 2;// Initialize row counter

        foreach ($members as $key => $items) {

            $sheet->setCellValue('A' . $row, $key+1);
            $sheet->setCellValue('B' . $row, $items['membership_id']);
            $sheet->setCellValue('C' . $row, $items['name']);
            $sheet->setCellValue('D' . $row,$items['sponsor_id']);
            $sheet->setCellValue('E' . $row, $items['sponsor_name']);
            $sheet->setCellValue('F' . $row,$items['mobile']);
            $sheet->setCellValue('G' . $row, $items['pan_card']);
            $sheet->setCellValue('H' . $row,$items['aadhar_card']);
            $sheet->setCellValue('I' . $row, $items['email']);
            $sheet->setCellValue('J' . $row,$items['pincode']);
            $sheet->setCellValue('K' . $row, $items['bank_name']);
            $sheet->setCellValue('L' . $row,$items['account_number']);
            $sheet->setCellValue('M' . $row, $items['ifsc_code']);
            $sheet->setCellValue('N' . $row,$items['account_name']);
            $sheet->setCellValue('O' . $row, $items['status']);
            $sheet->setCellValue('P' . $row,date('d M,Y', strtotime($items['created_at'])));

            $row++;
        }

       
       


        $writer = new Xlsx($spreadsheet);
        $fileName = "members-list.xlsx";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        $writer->save("php://output");
        exit();


@endphp

