<page backtop="15mm" backbottom="15mm" backleft="10mm" backright="10mm">
   <table style="width: 100%; border-bottom: 2px solid #222; padding-bottom: 10px; margin-top: 5px;">
      <tr>
         <td style="width: 55%;">
            <strong style="font-size: 16px; color: #111;">IDMETAFORA / CI3 METAFORA</strong><br>
            <span style="font-size: 11px; color: #555;">Sistem Penjualan, Pembelian &amp; Inventory</span><br>
            <span style="font-size: 10px; color: #666;">Telp: (0274) 123456 | Email: info@idmetafora.com</span>
         </td>
         <td style="width: 45%; text-align: right; vertical-align: top;">
            <strong style="font-size: 16px; color: #0056b3;">FAKTUR PENJUALAN / INVOICE</strong><br>
            <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 3px;">
               <tr>
                  <td style="width: 50%; text-align: right; padding: 1px 0; color: #1e293b;"><strong>No Invoice</strong></td>
                  <td style="width: 5%; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
                  <td style="width: 45%; text-align: left; padding: 1px 0; color: #1e293b;"><strong><?= _ent($invoice->nomor_invoice ?? '-'); ?></strong></td>
               </tr>
               <tr>
                  <td style="text-align: right; padding: 1px 0; color: #475569;"><strong>Tanggal</strong></td>
                  <td style="text-align: center; padding: 1px 0; color: #475569;">:</td>
                  <td style="text-align: left; padding: 1px 0; color: #475569;"><?= isset($invoice->tanggal_invoice) ? date('d/m/Y', strtotime($invoice->tanggal_invoice)) : '-'; ?></td>
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
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><strong><?= _ent($invoice->nama_pelanggan ?? '-'); ?></strong></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Jatuh Tempo</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($invoice->tanggal_jatuh_tempo ? date('d/m/Y', strtotime($invoice->tanggal_jatuh_tempo)) : '-'); ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Alamat</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; line-height: 1.35; word-wrap: break-word;"><?= nl2br(_ent($invoice->alamat_pelanggan ?? '-')); ?></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Status Kirim</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><strong><?= _ent(strtoupper($invoice->status_kirim ?? '-')); ?></strong></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>No Telp</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><?= _ent($invoice->telp_pelanggan ?? '-'); ?></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>No. Resi / AWB</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent(!empty($invoice->nomor_resi) ? $invoice->nomor_resi : '-'); ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 2%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top;"></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Ekspedisi</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent(!empty($invoice->ekspedisi) ? $invoice->ekspedisi : (!empty($invoice->kurir_ekspedisi) ? $invoice->kurir_ekspedisi : '-')); ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 2%; padding: 3px 0; vertical-align: top;"></td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top;"></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Petugas</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($invoice->created_by ?? '-'); ?></td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; border: 1px solid #ccc; border-collapse: collapse; font-size: 9.5px; table-layout: fixed;">
      <thead>
         <tr style="background: #f0f0f0;">
            <th style="width: 5%; border: 1px solid #ccc; padding: 5px 3px; text-align: center;">No</th>
            <th style="width: 35%; border: 1px solid #ccc; padding: 5px 6px; text-align: left;">Produk</th>
            <th style="width: 8%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Qty</th>
            <th style="width: 8%; border: 1px solid #ccc; padding: 5px 4px; text-align: center;">Satuan</th>
            <th style="width: 15%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Harga Satuan</th>
            <th style="width: 10%; border: 1px solid #ccc; padding: 5px 4px; text-align: right;">Disc (%)</th>
            <th style="width: 19%; border: 1px solid #ccc; padding: 5px 6px; text-align: right;">Subtotal</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($items)): ?>
            <?php $no = 1; foreach ($items as $it): ?>
               <tr>
                  <td style="border: 1px solid #ccc; padding: 5px 3px; text-align: center;"><?= $no++; ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 6px;"><?= _ent($it->nama_produk ?? '-'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: right;"><?= number_format($it->qty ?? 0, 0, ',', '.'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: center;"><?= _ent($it->satuan ?? '-'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px 4px; text-align: right; white-space: nowrap;">Rp <?= number_format($it->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                   <?php 
                      $inv_disc_pct = (float)($invoice->diskon_persen_total ?? 0);
                      if ($inv_disc_pct == 0 && !empty($invoice->diskon_total) && !empty($invoice->subtotal) && $invoice->subtotal > 0) {
                         $inv_disc_pct = round(($invoice->diskon_total / $invoice->subtotal) * 100, 1);
                      }
                      $it_disc = (float)(($it->diskon_persen > 0) ? $it->diskon_persen : $inv_disc_pct);
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
         <?php 
            $subtotal_val = (float) ($invoice->subtotal ?? 0);
            $diskon_val   = (float) ($invoice->diskon_total ?? 0);
            if ($diskon_val > $subtotal_val && $subtotal_val > 0) {
               $pct = min(100, $diskon_val / $subtotal_val);
               $diskon_val = $subtotal_val * ($pct / 100);
            }
            $pajak_pct    = (float) ($invoice->pajak_persen ?? 0);
            $after_disc_v = max(0, $subtotal_val - $diskon_val);
            $pajak_val    = $after_disc_v * ($pajak_pct / 100);
            $total_val    = $after_disc_v + $pajak_val;
            $diskon_pct_display = $subtotal_val > 0 ? round(($diskon_val / $subtotal_val) * 100, 1) : 0;
         ?>
         <tr>
            <td colspan="6" style="border: 1px solid #ccc; padding: 5px 8px; text-align: right;"><strong>Subtotal:</strong></td>
            <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; white-space: nowrap;">Rp <?= number_format($subtotal_val, 0, ',', '.'); ?></td>
         </tr>
         <?php if ($diskon_val > 0): ?>
         <tr>
            <td colspan="6" style="border: 1px solid #ccc; padding: 5px 8px; text-align: right; color: #c00;">Diskon Keseluruhan <?= $diskon_pct_display > 0 ? '('.$diskon_pct_display.'%)' : ''; ?>:</td>
            <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; color: #c00; white-space: nowrap;">- Rp <?= number_format($diskon_val, 0, ',', '.'); ?></td>
         </tr>
         <?php endif; ?>
         <?php if ($pajak_val > 0): ?>
         <tr>
            <td colspan="6" style="border: 1px solid #ccc; padding: 5px 8px; text-align: right;">Pajak (<?= $pajak_pct; ?>%):</td>
            <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; white-space: nowrap;">Rp <?= number_format($pajak_val, 0, ',', '.'); ?></td>
         </tr>
         <?php endif; ?>
         <tr style="background: #eef7ff;">
            <td colspan="6" style="border: 1px solid #ccc; padding: 5px 8px; text-align: right;"><strong>TOTAL INVOICE:</strong></td>
            <td style="border: 1px solid #ccc; padding: 5px 6px; text-align: right; white-space: nowrap;"><strong style="color:#0056b3;">Rp <?= number_format($total_val, 0, ',', '.'); ?></strong></td>
         </tr>
      </tfoot>
   </table>

   <?php if (!empty($invoice->catatan)): ?>
      <br>
      <div style="font-size: 10px; color: #333; background: #fdfdfd; border: 1px solid #eee; padding: 6px 10px; border-radius: 4px;">
         <strong>Catatan:</strong> <?= _ent($invoice->catatan); ?>
      </div>
   <?php endif; ?>

   <br><br>

   <table style="width: 100%; text-align: center; font-size: 11px;">
      <tr>
         <td style="width: 33%;">
            Dibuat Oleh,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 33%;">
            Penerima / Customer,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 34%;">
            Manager Keuangan,<br><br><br><br>
            ( ____________________ )
         </td>
      </tr>
   </table>
</page>