<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
   <table style="width: 100%; border-bottom: 2px solid #222; padding-bottom: 10px;">
      <tr>
         <td style="width: 55%;">
            <strong style="font-size: 16px; color: #111;">IDMETAFORA / CI3 METAFORA</strong><br>
            <span style="font-size: 11px; color: #555;">Sistem Penjualan, Pembelian &amp; Inventory</span><br>
            <span style="font-size: 10px; color: #666;">Telp: (0274) 123456 | Email: info@idmetafora.com</span>
         </td>
         <td style="width: 45%; text-align: right; vertical-align: top;">
            <strong style="font-size: 16px; color: #0056b3;">TRANSAKSI PENJUALAN</strong><br>
            <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 3px;">
               <tr>
                  <td style="width: 55%; text-align: right; padding: 1px 0; color: #1e293b;"><strong>No. Transaksi Penjualan</strong></td>
                  <td style="width: 5%; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
                  <td style="width: 40%; text-align: left; padding: 1px 0; color: #1e293b;"><strong><?= _ent($so->nomor_so ?? '-'); ?></strong></td>
               </tr>
               <tr>
                  <td style="text-align: right; padding: 1px 0; color: #475569;"><strong>Tanggal</strong></td>
                  <td style="text-align: center; padding: 1px 0; color: #475569;">:</td>
                  <td style="text-align: left; padding: 1px 0; color: #475569;"><?= isset($so->tanggal_so) ? date('d/m/Y', strtotime($so->tanggal_so)) : '-'; ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; font-size: 11px; border-collapse: collapse; table-layout: fixed;">
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Pelanggan</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><strong><?= _ent($so->nama_pelanggan ?? '-'); ?></strong></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Est. Kirim</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= !empty($so->tanggal_estimasi_kirim) ? date('d/m/Y', strtotime($so->tanggal_estimasi_kirim)) : '-'; ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Alamat</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; line-height: 1.35; word-wrap: break-word;"><?= nl2br(_ent($so->alamat_pelanggan ?? '-')); ?></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Salesperson</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($so->created_by ?? '-'); ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>No Telp</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><?= _ent($so->telp_pelanggan ?? '-'); ?></td>
         <td style="width: 15%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 2%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"></td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; border: 1px solid #ccc; border-collapse: collapse; font-size: 9.5px; table-layout: fixed;">
      <thead>
         <tr style="background: #f0f0f0;">
            <th style="width: 5%; border: 1px solid #ccc; padding: 5px 3px; text-align: center;">No</th>
            <th style="width: 35%; border: 1px solid #ccc; padding: 5px 6px; text-align: left;">Produk</th>
            <th style="width: 10%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Qty Order</th>
            <th style="width: 8%; border: 1px solid #ccc; padding: 5px 4px; text-align: center;">Satuan</th>
            <th style="width: 15%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Harga Satuan</th>
            <th style="width: 8%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Disc (%)</th>
            <th style="width: 19%; border: 1px solid #ccc; padding: 5px 6px; text-align: right;">Subtotal</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($items)): ?>
            <?php $no = 1; foreach ($items as $it): ?>
               <tr>
                  <td style="border: 1px solid #ccc; padding: 5px 3px; text-align: center;"><?= $no++; ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 6px;">
                     <?= _ent($it->nama_produk ?? '-'); ?>
                  </td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: right;"><?= number_format((float)($it->qty ?? 0), 0, ',', '.'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: center;"><?= _ent($it->singkatan ?? $it->satuan ?? '-'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: right; white-space: nowrap;">Rp <?= number_format($it->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                   <?php 
                      $so_disc_pct = (float)($so->diskon_persen_total ?? 0);
                      if ($so_disc_pct == 0 && !empty($so->diskon_total) && !empty($so->subtotal) && $so->subtotal > 0) {
                         $so_disc_pct = round(($so->diskon_total / $so->subtotal) * 100, 1);
                      }
                      if ($so_disc_pct > 100) {
                         $so_disc_pct = min(100, $so_disc_pct / 100);
                      }
                      $it_disc = (float)(($it->diskon_persen > 0) ? $it->diskon_persen : $so_disc_pct);
                      if ($it_disc > 100) {
                         if ($it_disc <= 10000) {
                            $it_disc = $it_disc / 100;
                         } else {
                            $it_disc = $so_disc_pct;
                         }
                      }
                      $it_disc_fmt = ($it_disc == floor($it_disc)) ? number_format($it_disc, 0) : number_format($it_disc, 1);
                   ?>
                   <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: right;"><?= $it_disc_fmt; ?>%</td>
                  <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; white-space: nowrap;">Rp <?= number_format($it->subtotal ?? 0, 0, ',', '.'); ?></td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr><td colspan="7" style="border: 1px solid #ccc; padding: 5px; text-align: center;">Tidak ada item.</td></tr>
         <?php endif; ?>
      </tbody>
      <tfoot>
         <tr style="background: #eef7ff;">
            <td colspan="6" style="border: 1px solid #ccc; padding: 5px 8px; text-align: right;"><strong>GRAND TOTAL:</strong></td>
            <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; white-space: nowrap;"><strong style="color:#0056b3;">Rp <?= number_format($so->total ?? 0, 0, ',', '.'); ?></strong></td>
         </tr>
      </tfoot>
   </table>

   <br><br><br>

   <table style="width: 100%; text-align: center; font-size: 11px;">
      <tr>
         <td style="width: 33%;">
            Sales Representative,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 33%;">
            Customer / Pemesan,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 34%;">
            Sales Manager,<br><br><br><br>
            ( ____________________ )
         </td>
      </tr>
   </table>
</page>