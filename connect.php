<!-- <?php

    //เชื่อมต่อ Database
    $conn = new mysqli('localhost','root','','bike_repair');
    //ตั้งค่าภาษาไทย
    $conn->set_charset("utf8");
    //ตรวจสอบว่า Database เชื่อมต่อสำเร็จหรือไม่
    if( $conn->connect_errno ){
        die("Connection failed" .$conn->connect_error);
    }
    function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear  $strHour:$strMinute";
	}

?> -->
