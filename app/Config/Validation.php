<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $register = [
		'username' => [
			'rules' => 'required|min_length[5]|is_unique[user.username]',
		],
		'password' => [
			'rules' => 'required|alpha_numeric',
		],
		'repeatPassword' => [
			'rules' => 'required|matches[password]',
		],
	];

	public $register_errors = [
		'username' => [
			'required' => '{field} Harus Diisi',
			'min_length' => '{field} Minimal 5 Karakter',
			'is_unique' => '{field} telah terdaftar'
		],
		'password' => [
			'required' => '{field} Harus Diisi',
			'alpha_numeric' => '{field} harus berupa angka dan huruf'
		],
		'repeatPassword' => [
			'required' => '{field} Harus Diisi',
			'matches' => 'Tidak Match Dengan Password'
		],
	];

	public $login = [
		'username' => [
			'rules' => 'required|min_length[5]',
		],
		'password' => [
			'rules' => 'required',
		],
	];
	public $login_errors = [
		'username' => [
			'required' => '{field} Harus Diisi',
			'min_length' => '{field} Minimal 5 Karakter',
		],
		'password' => [
			'required' => '{field} Harus Diisi',
		],
	];
	public $barang = [
		'nama' => [
			'rules' => 'required|min_length[3]',
		],
		'harga' => [
			'rules' => 'required|is_natural',
		],
		'stok' => [
			'rules' => 'required|is_natural',
		],
		'gambar' => [
			'rules' => 'uploaded[gambar]|max_size[gambar,8192]|is_image[gambar]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
		],
		'ukuran' => [
			'rules' => 'required'
		],
		'berat' => [
			'rules' => 'is_natural'
		],
	];

	public $barang_errors = [
		'nama' => [
			'required' => '{field} barang harus diisi',
			'min_length' => '{field} barang minimum 3 karakter',
		],
		'harga' => [
			'required' => '{field} harus diisi',
			'is_natural' => '{field} tidak boleh negatif',
		],
		'stok' => [
			'required' => '{field} Harus diisi',
			'is_natural' => '{field} Tidak Boleh Negatif',
		],
		'gambar' => [
			'uploaded' => '{field} harus di upload',
			'max_size' => 'ukuran gambar tidak boleh melebihi 8mb',
			'is_image' => 'input harus berupa gambar',
			'mime_in' => 'input harus berupa gambar'
		]
	];

	public $barangupdate = [
		'nama' => [
			'rules' => 'required|min_length[3]',
		],
		'harga' => [
			'rules' => 'required|is_natural',
		],
		'stok' => [
			'rules' => 'required|is_natural',
		],
	];

	public $barangupdate_errors = [
		'nama' => [
			'required' => '{field} Harus diisi',
			'min_length' => '{field} Minimum 3 karakter',
		],
		'harga' => [
			'required' => '{field} Harus diisi',
			'is_natural' => '{field} Tidak Boleh Negatif',
		],
		'stok' => [
			'required' => '{field} Harus diisi',
			'is_natural' => '{field} Tidak Boleh Negatif',
		],
	];
	public $transaksi = [
		'id_barang' => [
			'rules' => 'required',
		],
		'id_pembeli' => [
			'rules' => 'required',
		],
		'jumlah' => [
			'rules' => 'required',
		],
		'total_harga' => [
			'rules' => 'required',
		],
		'alamat' => [
			'rules' => 'required',
		],
		'service' => [
			'rules' => 'required'
		],
		'ongkir' => [
			'rules' => 'required',
		]
	];

	public $deskripsi = [
		'ukuran' => 'required',
		'berat' => 'is_natural',
	];
	public $deskripsiUpdate = [
		'ukuran' => 'required',
		'berat' => 'is_natural',
	];
	public $log = [
		'action' => 'required',
		'table_name' => 'required',
		'id_modified' => 'required',
		'change_date' => 'required',
		'id_modifier' => 'required',
	];
}
