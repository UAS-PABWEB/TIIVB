<?php
include "koneksi.php";


$jumlah = count ($_POST ["check_list"]);
for($i=0; $i < $jumlah; $i++)
{
$idrincianbiaya=$_POST["check_list"] [$i];
$myquery = "DELETE FROM rincianbiaya WHERE idrincianbiaya = '$idrincianbiaya' LIMIT 1";
$hapus = mysql_query($myquery);
?><script language="javascript">alert("Data yang ditandai berhasil dihapus !"); location.href="?page=data_rincianbiaya";</script><?php
}
?>