<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


include('../admin/configi.php');

$img[0] = "http://jernbane.net/upload_08/1422778445_Mgb-305_Snogh__j__241.010_.jpg";
$img[1] = "http://jernbane.net/upload_08/1422778048_Mgb-326_Sprog____241.008_.jpg";
$img[2] = "http://jernbane.net/upload_08/1422778317_Mgb-272___resundsbron__241.002_.jpg";
$img[3] = "http://jernbane.net/upload_08/1422824486_image.jpg";
$img[4] = "http://jernbane.net/upload_08/1422860088_IMG_6830.jpg";
$img[5] = "http://jernbane.net/upload_08/1422868556_20140810_X31_4539_2.jpg";
$img[6] = "http://jernbane.net/upload_08/1422957826_tnDSC01274.jpg";
$img[7] = "http://jernbane.net/upload_08/1422958105_tnDSC01475.jpg";
$img[8] = "http://jernbane.net/upload_08/1422958399_tnDSC01513.jpg";
$img[9] = "http://jernbane.net/upload_08/1423083694_7.9.JPG";
$img[10] = "http://jernbane.net/upload_08/1423083694_8.11.JPG";
$img[11] = "http://jernbane.net/upload_08/1423083694_29.6.JPG";
$img[12] = "http://jernbane.net/upload_08/1423166419_mb_d140040126.jpg";
$img[13] = "http://jernbane.net/upload_08/1423169892_Tog_42._23.09.14.jpg";
$img[14] = "http://jernbane.net/upload_08/1422816148_30041403.JPG";
$img[15] = "http://jernbane.net/upload_08/1422816952_image.jpg";
$img[16] = "http://jernbane.net/upload_08/1422829365_7212.jpg";
$img[17] = "http://jernbane.net/upload_08/1422816922_06091401.JPG";
$img[18] = "http://jernbane.net/upload_08/1422819030_CD_312_001_Dovre.jpg";
$img[19] = "http://jernbane.net/upload_08/1422824020_image.jpg";
$img[20] = "http://jernbane.net/upload_08/1423220885_benesovnadploucnici.jpg";
$img[21] = "http://jernbane.net/upload_08/1422816582_01081427.JPG";
$img[22] = "http://jernbane.net/upload_08/1423243555_IMG_5267.JPG";
$img[23] = "http://jernbane.net/upload_08/1423298707_U-Bahnhof_Alexanderplatz__Berlin.JPG";
$img[24] = "http://jernbane.net/upload_08/1423299184_SJ_2000_Cst-Str__mstad_i_Smedberg.jpg";
$img[25] = "http://jernbane.net/upload_08/1423299688_Ra_846_med_t__g_mot_J__rvs___vid_Ockelbo.jpg";
$img[26] = "http://jernbane.net/upload_08/1422792983_LJ_28.04.14_004.JPG";
$img[27] = "http://jernbane.net/upload_08/1423386403_DSB_03.05.14_016.JPG";
$img[28] = "http://jernbane.net/upload_08/1423387857_LJ_30.06.14_065.JPG";
$img[29] = "http://jernbane.net/upload_08/1423157278_185712-8_5804_km210_630_5C1A1924s12konk.jpg";
$img[30] = "http://jernbane.net/upload_08/1423502086_2015-01-28_13.10.16.jpg";
$img[31] = "http://jernbane.net/upload_08/1423571220_W4030029.JPG";
$img[32] = "http://jernbane.net/upload_08/1423672037_KBTP_41614.JPG";
$img[33] = "http://jernbane.net/upload_08/1423672484_KBTP_40555.JPG";
$img[34] = "http://jernbane.net/upload_08/1423672802_KBTP_42925.JPG";
$img[35] = "http://jernbane.net/upload_08/1423169419_Tog_42__02.10.14.jpg";
$img[36] = "http://jernbane.net/upload_08/1423298154_Tsjekkia-Slovakia_614.JPG";
$img[37] = "http://jernbane.net/upload_08/1423502888_A6000_nattbilder_038.JPG";
$img[38] = "http://jernbane.net/upload_08/1423848968_Kosovo_Makedonia_437.JPG";
$img[39] = "http://jernbane.net/upload_08/1424019415_20140909-IMG_7150.jpg";
$img[40] = "http://jernbane.net/upload_08/1424019656_20140918-IMG_8949.jpg";
$img[41] = "http://jernbane.net/upload_08/1424019708_20140919-IMG_9951.jpg";
$img[42] = "http://jernbane.net/upload_08/1424370071_St__ren_141223-5ws2_Morgen.jpg";
$img[43] = "http://jernbane.net/upload_08/1424370358_Heimdal_140201-11ws2_Morgen.jpg";
$img[44] = "http://jernbane.net/upload_08/1424370505_Tog_42_141223-13ws2_St__ren.jpg";
$img[45] = "http://jernbane.net/upload_08/1424455939_IMG_9800.jpg";
$img[46] = "http://jernbane.net/upload_08/1424456587_IMG_9768.jpg";
$img[47] = "http://jernbane.net/upload_08/1424457869_IMG_0603.jpg";
$img[48] = "http://jernbane.net/upload_08/1424626717_PA105824.JPG";
$img[50] = "http://jernbane.net/upload_08/1424732353_munch.jpg";
$img[51] = "http://jernbane.net/upload_08/1422811034_20140807_vgj24_grafsnas.jpg";
$img[52] = "http://jernbane.net/upload_08/1425804492_20140424_X61407.jpg";
$img[53] = "http://jernbane.net/upload_08/1424849629__CFS0091.jpg";
$img[54] = "http://jernbane.net/upload_08/1424849767_CF_Salicath-2455.jpg";
$img[55] = "http://jernbane.net/upload_08/1424849972_CF_Salicath-6406.jpg";
$img[56] = "http://jernbane.net/upload_08/1425142030_WB110443.JPG";
$img[57] = "http://jernbane.net/upload_08/1425591033_2014-05-24_2056.jpg";
$img[58] = "http://jernbane.net/upload_08/1425591568_2014-01-29_1117.jpg";
$img[59] = "http://jernbane.net/upload_08/1425670026_image.jpg";
$img[60] = "http://jernbane.net/upload_08/1424992512_DSC_0006.JPG";
$img[61] = "http://jernbane.net/upload_08/1425154908_CSC_0061-001.jpg";
$img[62] = "http://jernbane.net/upload_08/1424988569_DSC_2559.jpg";
$img[63] = "http://jernbane.net/upload_08/1425065835_DSC_3082.JPG";
$img[64] = "http://jernbane.net/upload_08/1424993710_IMG_0390.jpg";
$img[65] = "http://jernbane.net/upload_08/1425323291_A140601-004.JPG";
$img[66] = "http://jernbane.net/upload_08/1424896579_DONJ12.jpg";
$img[67] = "http://jernbane.net/upload_08/1424956348_f1200_jvmd14_140920.jpg";
$img[68] = "http://jernbane.net/upload_08/1424942842_JBV_plaskepunkt_5C1A1304s12.jpg";
$img[69] = "http://jernbane.net/upload_08/1424956639_Rc6_1417_i_Hallsberg_30_juli_2014.jpg";
$img[70] = "http://jernbane.net/upload_08/1424907244_DSC_0711.JPG";
$img[71] = "http://jernbane.net/upload_08/1426785346_616-melhus.jpg";
$img[72] = "http://jernbane.net/upload_08/1426785657_myrdal-18-17.jpg";
$img[73] = "http://jernbane.net/upload_08/1426786036_slovakia-train.jpg";
$img[74] = "http://jernbane.net/upload_08/1427369810_DSC_2875.JPG";
$img[75] = "http://jernbane.net/upload_08/1427749025_DSC_2178.JPG";
$img[76] = "http://jernbane.net/upload_08/1427749541_DSC_4208.JPG";
$img[77] = "http://jernbane.net/upload_08/1427750947_DSC_9446.JPG";
$img[78] = "http://jernbane.net/upload_08/1427784619_2014-06-02-nasa.jpg";


for ($n = 0 ; $n<79 ; $n++) {
	
	$query = "select url, id, thumb, sum(poeng) as sumpoeng, sum(stemmer) as sumstememr, type, fotograf from gal_images where url = '$img[$n]' group by url";

	$result = $db->query($query);
	$res = $result->fetch_array();
		echo $n; echo " - "; echo $res[0].' - '.$res[3].' - '.$res[4].' - '.$res[6].'<br />';

	$query4 = "insert into misc_konkurranse (imgid, thumb, poeng, stemmer, fotograf) values ('$res[1]', '$res[2]', '$res[3]', '$res[4]','$res[6]')"; 
	$result4 = mysqli_query($db, $query4);
	
	
	
}





?>

