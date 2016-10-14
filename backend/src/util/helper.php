<?php
class Helper {
    
    static function OutputToCSV($data) {
        $time = date("m-d-Y",time());
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=iot_'.$time.'.csv');
        $output = fopen("php://output", "w");
        
        $first = true;
        
        foreach ($data as $row) {
            
            $arr = $row->toArray();
            if ($first){
                //column headers
                fputcsv($output, array_keys($arr));
                $first = false;
            }
            fputcsv($output, $arr);
        }
        
        fclose($output);
    }

}