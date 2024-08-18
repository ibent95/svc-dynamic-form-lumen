<?php

/**
 * Entity for Publication
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Publication
 */
class Publication extends Model
{

    /**
     * Table name
     * 
     * @var string
     */
    protected $table = "pendaftaran";

    /**
     * CREATED_AT column name
     * 
     * @var string
     */
    const CREATED_AT = 'tgl_input';

    /**
     * UPDATED_AT column name
     * 
     * @var string
     */
    const UPDATED_AT = 'tgl_update';

    /**
     * The column names that should be guard
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * The fillable column names
     * 
     * @var array
     */
    protected $fillable = ['row_id', 'id', 'id_status_proses', 'id_verifikator', 'nomor_registrasi', 'niu', 'id_lowongan', 'id_kategori_kelompok_pegawai', 'kd_kategori_kelompok_pegawai', 'tgl_pendaftaran', 'tgl_mulai', 'tgl_selesai', 'id_status_pendaftaran', 'kd_status_pendaftaran', 'user_input', 'user_update', 'id_status_verifikasi', 'kd_status_verifikasi', 'flag_ajukan_perbaikan'];

    /**
     * The hidden column names
     * 
     * @var array
     */
    protected $hidden = ['row_id', 'id', 'id_status_proses', 'id_verifikator', 'id_lowongan', 'id_kategori_kelompok_pegawai', 'id_status_pendaftaran', 'id_status_verifikasi', 'id_tahap', 'flag_aktif', 'flag_delete', 'flag_terpakai', 'user_input', 'tgl_input', 'user_update', 'tgl_update'];

    /**
     * The properties that want to be cast and the types
     * 
     * @var array
     */
    protected $casts = [
        'lahir_tgl' => 'datetime:Y-m-d H:i:s',
        'tgl_input' => 'datetime:Y-m-d H:i:s',
        'tgl_update' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

}
