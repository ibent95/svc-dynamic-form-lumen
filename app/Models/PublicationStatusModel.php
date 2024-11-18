<?php

/**
 * Entity for PublicationFormVersion
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicationFormVersion
 */
class PublicationStatusModel extends Model
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "publication_status";

    /**
     * CREATED_AT column name
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * UPDATED_AT column name
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

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
    protected $hidden = ['row_id', 'id', 'id_publication_general_type', 'flag_active', 'create_user', 'created_at', 'update_user', 'updated_at'];

    /**
     * The properties that want to be cast and the types
     *
     * @var array
     */
    protected $casts = [
        'grid_system' => 'json',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

    //public function hasOneRelationship()
    //{
    //    return $this->hasOne(TargetModel::class, 'id', 'id_target_foreign_key_column_name_in_this_table');
    //}

    //public function hasmanyRelationship()
    //{
    //    return $this->hasMany(TargetModel::class, 'id_target_foreign_key_column_name_in_this_table', 'id');
    //}

    public function scopeActive($query): void
    {
        $query->where('flag_active', true);
    }

}
