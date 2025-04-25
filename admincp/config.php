<?php
 $link=@mysqli_connect("localhost","root","") or die("lỗi kết nối database");
 mysqli_select_db($link,"project-watch") or die("databse không kết nối");
 ?>
