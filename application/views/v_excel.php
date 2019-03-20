<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data-catatan-rekon.xls");
?>

<table border="1">
    <tr>
        <th>NOAGENDA</th>
        <th>IDPEL</th>
        <th>JENIS_TRANSAKSI</th>
        <th>NO_TIKET</th>
        <th>PERMINTAAN_DARI</th>
        <th>PERIHAL</th>
        <th>NO_BA</th>
        <th>ID_USER</th>
        <th>TGL_CATAT</th>
        <th>TGL_PERMINTAAN</th>
    </tr>

    <?php foreach ($rs_data as $row) { ?>
        <tr>
            <td><?php echo $row['NOAGENDA']; ?>&nbsp;</td>
            <td><?php echo $row['IDPEL']; ?>&nbsp;</td>
            <td><?php echo $row['JENIS_TRANSAKSI']; ?></td>
            <td><?php echo $row['NO_TIKET']; ?></td>
            <td><?php echo $row['PERMINTAAN_DARI']; ?></td>
            <td><?php echo $row['PERIHAL']; ?></td>
            <td><?php echo $row['NO_BA']; ?></td>
            <td><?php echo $row['ID_USER']; ?></td>
            <td><?php echo $row['TGL_CATAT']; ?></td>
            <td><?php echo $row['TGL_PERMINTAAN']; ?></td>
        </tr>
    <?php } ?>
</table>