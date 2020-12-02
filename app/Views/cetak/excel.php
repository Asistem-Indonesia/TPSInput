<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Tes.xls");
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Laporan</title>
</head>

<body>
   <h3>REKAP DAFTAR SUARA TINGKAT KALURAHAN<br>
      PEMILIHAN BUPATI DAN WAKIL BUPATI<br>
      GUNUNGKIDULTAHUN 2020</h3>
   <table border="1" cellspacing="0">
      <thead>

         <th>
            No
         </th>
         <th>
            Kecamatan
         </th>
         <th>
            Kelurahan
         </th>
         <th>
            Jumlah TPS
         </th>
         <?php foreach ($paslon as $p) : ?>
            <th>
               <?= $p['no_urut']; ?>
            </th>
         <?php endforeach; ?>
         <th>
            Total
         </th>
         <th>
            Target
         </th>
         <th>
            Selisih
         </th>
      </thead>
      <tbody>
         <?php
         $n = 1;
         foreach ($kelurahan as $kl) : ?>
            <tr>
               <td><?= $n; ?></td>
               <td>
                  <!-- kecamatan -->
                  <?php

                  $kecamatan = $kecamatanModel->getKecamatan($kl['kecamatan_id']);

                  echo $kecamatan['kecamatan'];
                  ?>
               </td>
               <td>
                  <!-- kelurahan -->
                  <?= $kl['kelurahan']; ?>
               </td>

               <td>
                  <!-- jumlah tps -->
                  <?php

                  $tps = $tpsModel->getTpsByKelurahanId($kl['id']);
                  $totalTps[] = count(array_column($tps, 'tps'));
                  echo count(array_column($tps, 'tps'));
                  ?>
               </td>
               <?php
               $nb = 0;
               foreach ($paslon as $p) : ?>
                  <td>
                     <?php

                     $HasilPerKelurahanByCalonId = $tpsModel->getHasilPerKelurahanByCalonId($kl['id'], $p['id']);
                     $totalHasilPaslon[$n][] = array_sum(array_column($HasilPerKelurahanByCalonId, 'hasil'));
                     echo array_sum(array_column($HasilPerKelurahanByCalonId, 'hasil'));

                     $totalPerPaslon[$nb][$n][] = array_sum(array_column($HasilPerKelurahanByCalonId, 'hasil'));
                     ?>

                  </td>
               <?php endforeach; ?>
               <td>
                  <?php $totalJumlah[] = array_sum($totalHasilPaslon[$n]);
                  echo array_sum($totalHasilPaslon[$n]);
                  ?>

               </td>
               <td>
                  <?php $totalTarget[] = $kl['total'];
                  echo $kl['total'];
                  ?>
               </td>
               <td>
                  <?php
                  $selisih[] = $kl['total'] - array_sum($totalHasilPaslon[$n]);
                  echo $kl['total'] - array_sum($totalHasilPaslon[$n]);
                  ?>
               </td>
            </tr>
         <?php
            $n++;
         endforeach; ?>
         <tr>
            <td colspan="3">Total</td>
            <td>
               <?= array_sum($totalTps); ?>
            </td>
            <?php
            $nb = 0;
            foreach ($paslon as $p) : ?>
               <td>
                  <?= array_sum(array_column($totalPerPaslon[0], $nb)); ?>
               </td>
            <?php $nb++;
            endforeach; ?>
            <td>
               <?= array_sum($totalJumlah); ?>
            </td>
            <td>
               <?= array_sum($totalTarget); ?>
            </td>
            <td>
               <?= array_sum($selisih) ?>
            </td>
         </tr>
      </tbody>
   </table>
</body>

</html>