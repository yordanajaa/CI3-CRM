<style type="text/css">
	* {
		font-family: Arial, Helvetica, sans-serif;
		color: #1e293b;
		box-sizing: border-box;
	}
	.nowrap {
		white-space: nowrap !important;
	}
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
   <table style="width: 100%; border-bottom: 2px solid #0f172a; padding-bottom: 10px;">
      <tr>
         <td style="width: 55%; vertical-align: top;">
            <strong style="font-size: 16px; color: #0f172a;">IDMETAFORA &mdash; SISTEM ERP</strong><br>
            <span style="font-size: 11px; color: #64748b;">Sistem Manajemen Penjualan, Pembelian &amp; Inventory</span><br>
            <span style="font-size: 10px; color: #94a3b8;">Email: info@idmetafora.com | www.idmetafora.com</span>
         </td>
         <td style="width: 45%; text-align: right; vertical-align: top;">
            <strong style="font-size: 16px; color: #1e40af;">NOTA RETUR PENJUALAN</strong><br>
            <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 3px;">
               <tr>
                  <td style="width: 45%; text-align: right; padding: 1px 0; color: #1e293b;"><strong>No. Retur</strong></td>
                  <td style="width: 5%; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
                  <td style="width: 50%; text-align: left; padding: 1px 0; color: #1e293b;"><strong><?= _ent($retur->nomor_retur ?? '-'); ?></strong></td>
               </tr>
               <tr>
                  <td style="text-align: right; padding: 1px 0; color: #475569;"><strong>Tanggal</strong></td>
                  <td style="text-align: center; padding: 1px 0; color: #475569;">:</td>
                  <td style="text-align: left; padding: 1px 0; color: #475569;"><?= isset($retur->tanggal_retur) ? date('d/m/Y', strtotime($retur->tanggal_retur)) : '-'; ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; font-size: 11px; border-collapse: collapse;">
      <tr>
         <td style="width: 50%; vertical-align: top; padding-right: 15px;">
            <table style="width: 100%; border-collapse: collapse;">
               <tr>
                  <td style="width: 32%; padding: 3px 0; color: #64748b;"><strong>Pelanggan</strong></td>
                  <td style="width: 4%; padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="width: 64%; padding: 3px 0;"><strong><?= _ent($retur->nama_pelanggan ?? '-'); ?></strong></td>
               </tr>
               <tr>
                  <td style="padding: 3px 0; color: #64748b;"><strong>Ref. Invoice</strong></td>
                  <td style="padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="padding: 3px 0;"><?= _ent($retur->nomor_invoice ?? '-'); ?></td>
               </tr>
               <tr>
                  <td style="padding: 3px 0; color: #64748b;"><strong>Alasan Retur</strong></td>
                  <td style="padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="padding: 3px 0;"><?= _ent(ucwords(str_replace('_', ' ', $retur->alasan ?? '-'))); ?></td>
               </tr>
            </table>
         </td>
         <td style="width: 50%; vertical-align: top; padding-left: 15px;">
            <table style="width: 100%; border-collapse: collapse;">
               <tr>
                  <td style="width: 38%; padding: 3px 0; color: #64748b;"><strong>Tindak Lanjut</strong></td>
                  <td style="width: 4%; padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="width: 58%; padding: 3px 0; font-weight: bold; color: #0284c7;"><?= !empty($retur->tindak_lanjut) ? _ent(ucwords(str_replace('_', ' ', $retur->tindak_lanjut))) : '-'; ?></td>
               </tr>
               <tr>
                  <td style="padding: 3px 0; color: #64748b;"><strong>Petugas Pembuat</strong></td>
                  <td style="padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="padding: 3px 0;"><?= _ent($retur->created_by ?? '-'); ?></td>
               </tr>
               <tr>
                  <td style="padding: 3px 0; color: #64748b;"><strong>Status Dokumen</strong></td>
                  <td style="padding: 3px 0; text-align: center; color: #64748b;">:</td>
                  <td style="padding: 3px 0; font-weight: bold; color: <?= ($retur->status == 'selesai' || $retur->status == 'approved') ? '#15803d' : '#475569'; ?>;"><?= strtoupper($retur->status ?? '-'); ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; border: 1px solid #cbd5e1; border-collapse: collapse; font-size: 10.5px;">
      <thead>
         <tr style="background: #0f172a; color: #ffffff;">
            <th style="width: 5%; border: 1px solid #0f172a; padding: 7px 5px; text-align: center; color: #fff;">No</th>
            <th style="width: 38%; border: 1px solid #0f172a; padding: 7px 8px; text-align: left; color: #fff;">Produk</th>
            <th style="width: 12%; border: 1px solid #0f172a; padding: 7px 8px; text-align: center; color: #fff; white-space: nowrap;">Qty Retur</th>
            <th style="width: 15%; border: 1px solid #0f172a; padding: 7px 8px; text-align: right; color: #fff; white-space: nowrap;">Harga Satuan</th>
            <th style="width: 12%; border: 1px solid #0f172a; padding: 7px 8px; text-align: center; color: #fff; white-space: nowrap;">Kondisi</th>
            <th style="width: 18%; border: 1px solid #0f172a; padding: 7px 8px; text-align: right; color: #fff; white-space: nowrap;">Subtotal</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($items)): ?>
            <?php $no = 1; foreach ($items as $it): 
               $is_even = ($no % 2 == 0);
               $bg_r = $is_even ? 'background:#f8fafc;' : 'background:#ffffff;';
            ?>
               <tr style="<?= $bg_r; ?>">
                  <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 6px 5px; text-align: center;"><?= $no++; ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 6px 8px;"><strong><?= _ent($it->nama_produk ?? '-'); ?></strong></td>
                  <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 6px 8px; text-align: center; font-weight: bold;"><?= number_format($it->qty_retur ?? 0, 0, ',', '.'); ?></td>
                  <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 6px 8px; text-align: right;">Rp <?= number_format($it->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                  <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 6px 8px; text-align: center; font-weight: bold; color: <?= ($it->kondisi == 'rusak') ? '#b91c1c' : '#15803d'; ?>;">
                     <?= _ent(ucfirst($it->kondisi ?? 'Baik')); ?>
                  </td>
                  <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 6px 8px; text-align: right; font-weight: bold;">Rp <?= number_format($it->subtotal ?? 0, 0, ',', '.'); ?></td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr><td colspan="6" style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; color: #64748b;">Tidak ada item retur.</td></tr>
         <?php endif; ?>
      </tbody>
      <tfoot>
         <tr style="background: #e2e8f0; font-weight: bold;">
            <td colspan="5" class="nowrap" style="border: 1px solid #cbd5e1; padding: 8px; text-align: right; font-size: 11px;">TOTAL RETUR PENJUALAN:</td>
            <td class="nowrap" style="border: 1px solid #cbd5e1; padding: 8px; text-align: right; font-size: 11.5px; color: #1e40af;">Rp <?= number_format($retur->total ?? 0, 0, ',', '.'); ?></td>
         </tr>
      </tfoot>
   </table>

   <br><br><br>

   <table style="width: 100%; text-align: center; font-size: 11px; border-collapse: collapse;">
      <tr>
         <td style="width: 33%;">
            Penerima Retur,<br><br><br><br>
            <strong>( <?= get_user_data('username') ?: 'Staff Logistik'; ?> )</strong>
         </td>
         <td style="width: 33%;">
            Pelanggan,<br><br><br><br>
            <strong>( <?= _ent($retur->nama_pelanggan ?? '____________________'); ?> )</strong>
         </td>
         <td style="width: 34%;">
            Manager CS / Operasional,<br><br><br><br>
            <strong>( ____________________ )</strong>
         </td>
      </tr>
   </table>
</page>