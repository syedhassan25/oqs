$weekdayssalary = [];

$weekdayssalary = DB::Select("SELECT * FROM ClassPerSalaryAmount");
foreach ($weekdayssalary as $index => $studentdaysrow) {
    $weekdayssalary[] = $studentdaysrow;
}

($this->searchForId((int) $studentnorow, $weekdayssalary, $studenttafseer) * $durationWise) + $incrementPerclass;


public function searchForId($id, $array, $istafseer)
    {
        foreach ($array as $key => $val) {
            if ($val->day === $id && $istafseer == 0) {
                return $val->amount;
            } else if ($val->day === $id && $istafseer == 1) {
                return $val->tafeerAmount;
            }
        }
        return null;
    }