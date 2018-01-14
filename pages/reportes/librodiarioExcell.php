<?php
/** Incluir la libreria PHPExcel */
include '../../Classes/PHPExcel.php';

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Libro Diario-PACHOLI")
->setSubject("Libro Diario.")
->setDescription("Se mostrara todo el registro diario de nuestras partidas")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Libro Diario.");
//arrays que contendran los formatos de las fuentes para las celdas.
$styleArray = array(
    'font' => array(
        'bold' => false,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    // 'borders' => array(
    //     'top' => array(
    //         'style' => PHPExcel_Style_Border::BORDER_THIN,
    //     ),
    // ),
    // 'fill' => array(
    //     'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
    //     'rotation' => 90,
    //     'startcolor' => array(
    //         'argb' => 'FFA0A0A0',
    //     ),
    //     'endcolor' => array(
    //         'argb' => 'FFFFFFFF',
    //     ),
    // ),
);
$cont=3;
// Agregar Informacion
$objPHPExcel->getActiveSheet()->getStyle('B1')
->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(27);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('B1', 'LIBRO DIARIO')
->mergeCells('B1:E1')
->setCellValue('B2', 'Fecha')
->setCellValue('C2', 'Codigo')
->setCellValue('D2', 'Concepto')
->setCellValue('E2', 'Debe')
->setCellValue('F2', 'Haber');
//recuperamos de la bd y procedemos a insertar en las celdas.

include "../../config/conexion.php";
$result = $conexion->query("select * from partida order by idpartida ASC");
if ($result) {
  while ($fila = $result->fetch_object()) {
      echo "<td>" . $fila->fecha . "</td>";
      echo "<td colspan='4' align='center'>Partida #" . $fila->idpartida . "</td>";
    //  echo "<td>" . $fila->tipocuenta . "</td>";
    //  echo "<td>" . $fila->saldo . "</td>";

      echo "</tr>";
      $idpartida=$fila->idpartida;
      $result2 = $conexion->query("select * from ldiario where idpartida='".$idpartida."'order by debe DESC");

      if ($result2) {

        while ($fila2 = $result2->fetch_object()) {
          $cuenta=$fila2->idcatalogo;
          $debe=$fila2->debe;
          $haber=$fila2->haber;

          //para mostrar la Cuenta
          $result3 = $conexion->query("select * from catalogo where idcatalogo=".$cuenta);
          if ($result3) {
            while ($fila3 = $result3->fetch_object()) {
              $codigocuenta=$fila3->codigocuenta;
              $nombrecuenta=$fila3->nombrecuenta;
              echo "<tr>";
                echo "<td> </td>";
                echo "<td align='center'> " . $codigocuenta . "</td>";
                if ($debe>=$haber) {
                  echo "<td align='left'>" . $nombrecuenta . "</td>";
                }else {

                  echo "<td align='center'>" . $nombrecuenta . "</td>";
                }
                if ($debe==0) {
                    echo "<td align='center' class='info'>--</td>";
                }else {
                  echo "<td align='left' class='info'>$ " . $debe . "</td>";
                }
                if ($haber==0) {
                    echo "<td align='center' class='danger'>--</td>";
                }else {
                  echo "<td align='left' class='danger'>$ " . $haber . "</td>";
                }


              echo "</tr>";
            }
          }
        }
      }
      echo "<tr class='warning'>";
      echo "<td> </td>";
      echo "<td> </td>";
      echo "<td align='center' >V/ ".$fila->concepto."</td>";
      echo "<td> </td>";
      echo "<td> </td>";
      echo "</tr>";
  }
}

// $result = $conexion->query("select * from catalogo order by codigocuenta");
// if ($result) {
//   while ($fila = $result->fetch_object()) {
//     $objPHPExcel->getActiveSheet()->getStyle('B'."$cont")->applyFromArray($styleArray);
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValue('B'."$cont",$fila->codigocuenta)
//     ->setCellValue('C'."$cont",$fila->nombrecuenta)
//     ->setCellValue('D'."$cont",$fila->tipocuenta)
//     ->setCellValue('E'."$cont",$fila->saldo);
//       $cont++;
//
//   }
// }
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('LibroDiario');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="LibroDiario.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body onload="window.close()">

  </body>
</html>
