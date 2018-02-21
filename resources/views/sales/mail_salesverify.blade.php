<?php
	$title = "業務驗證";
?>
<table style="width:600px;margin: 0 auto;font-family:微軟正黑體; font-size:14px;">
    <thead>
        <tr>
            <th style="text-align: center;font-size:25px;padding-bottom:20px;">業務驗證通知</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:5px 0 5px 40px;">業務驗證路徑：{{ $salesVerifyUri }}</td>
        </tr>
        <tr>
            <td> <a href="{{ $salesVerifyUri }}">點擊跳頁</a> </td>
        </tr>
    </tbody>
</table>