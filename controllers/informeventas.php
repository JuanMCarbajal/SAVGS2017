<?php 
//controllers/informeventas.php

require '../framework/fw.php';
require '../models/Clientes.php';
require '../views/InformeVentas.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$cli=new Clientes;
$vista=new InformeVentas;	
	
$vista->clientes=$cli->getDeudaTotal();
	
	
	/* Generacion de archivo Excel */
	
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

	date_default_timezone_set('America/Argentina/Buenos_Aires');

	/** Include PHPExcel  **/
	require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
	
	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("SAVGS")
					 ->setLastModifiedBy("SAVGS")
					 ->setTitle("InformeVentas".date('d-m-y'))
					 ->setSubject("InformeVentas".date('d-m-y'))
					 ->setDescription("Informe de Ventas")
					 ->setKeywords("informe ventas")
					 ->setCategory("Informe");
	
	$i=1;
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 'Codigo');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, 'Nombre');
	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, 'Deuda Inicial');
	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, 'Deuda Semanal');
	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, 'Deuda Total');
	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, 'Pagado');
	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(true);
	$i++;	
	
	foreach($vista->clientes as $item)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item['codigo_cliente']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['nombre_cliente']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, "$".round($item['deuda_general']-$item['deuda_semanal'],2));
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, "$".round($item['deuda_semanal'],2));
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, "$".round($item['deuda_general'],2));
		$i++;
	}
	$i=$i-1;
	$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save(str_replace('.php', date('d-m-y').'.xlsx', __FILE__));

$vista->render();
?>