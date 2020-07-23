<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Web Programing UBL <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<!-- Sweet Alert -->
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- My JS -->
<script src="<?= base_url('assets/') ?>js/scripttss.js"></script>



<script>
const base_url = "http://localhost/tugas_akhir/";  // SESUAIKAN SAAT HOSTING
const attrPenduduk = [
		'nik',
		'no_ktp',
		'nama',
		'tmpt_tgl_lahir',
		'agama',
		'pekerjaan',
		'alamat',
		'dusun',
		'rt',
		'rw',
		'jk',
		'kewarganegaraan',
		'sts_kawin',
		'pendidikan',
		'suku'
	];
	const formLabelPenduduk = [
		'NIK',
		'Nomer KTP',
		'Nama',
		'Tempat Tanggal Lahir',
		'Agama',
		'Pekerjaan',
		'Alamat',
		'Dusun',
		'RT',
		'RW',
		'Jenis Kelamin',
		'Kewarganegaraan',
		'Status Kawin',
		'Pendidikan',
		'Suku'
	];

	const attrSubmenu = [
		'judul',
		'menu_id',
		'url',
		'ikon'
	];

	const formLabelSubmenu = [
		'Judul',
		'Menu',
		'URL',
		'Ikon'
	];

	formLabel = (x) => {
		return "<label for='" + x + "'></label>"
	}

	// -------------------------------------------------------------------------------------//

    // SCRIPT UNTUK EDIT PROFILE

    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(filename);
    })

	// -------------------------------------------------------------------------------------//

    // SCRIPT UNTUK PENCARIAN PENDUDUK DI FORM SURAT IZIN USAHA

    function load_data(key) {
        $.ajax({
            url: "<?= base_url('/surat/cariPenduduk') ?>",
            method: "post",
            data: {
                key: key
            },
            success: data => {
                $("#result").html(data);
            }
        });
    }

    $("#keyword").on("keyup", function() {
        const keyword = $(this).val();

        if (keyword != "") {
            load_data(keyword);
        } else {
            load_data();
        }
    });

    $(document).on("click", ".tombolSubmit", function(e) {
        e.preventDefault();
        const id = $(this).data("id");
        $.ajax({
            url: "<?= base_url('/surat/getPendudukById/') ?>" + id,
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#nama").val(data.nama);
                $("#no_ktp").val(data.no_ktp);
                $("#ttl").val(data.tmpt_tgl_lahir);
                $("#jk").val(data.jk);
                $("#kewarganegaraan").val(data.kewarganegaraan);
                $("#agama").val(data.content_agama);
                $("#alamat").val(data.alamat);

                $("#result").html('');
                $("#keyword").val('');
            }
        });
    });

	// -------------------------------------------------------------------------------------//

    // SCRIPT SWEEAT ALERT UNTUK CONFIRMASI HAPUS DATA
	$(".badge-danger").on("click", function () {
        
		const menu = $(this).data("menu");
		const method = $(this).data("method");
        const userId = $(this).data("id");
		event.preventDefault();
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data akan dihapus!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Hapus!"
		}).then(result => {
			if (result.value) {
				Swal.fire({
					type: "success",
					title: "Data berhasil dihapus",
					showConfirmButton: false
				});
				setTimeout(function () {
                    document.location.href =
                        base_url +
						"/" +
						menu +
						"/" +
						method +
						"/" +
						userId;
				}, 2000);
			}
		});
    });

	// -------------------------------------------------------------------------------------//
    
    // SCRIPT UNTUK UBAH MENU

    $(".ubahMenu").on("click", function () {
        console.log("data-judul")
		$("#newMenuModalLabel").html("Ubah Menu"); // mengubah judul modal
		$(".modal-footer button[type=submit]").html("Ubah"); // mengubah judul tombol modal
		$(".modal-content form").attr("action", base_url + "menu/editMenu"); // mengubah action form modal

		$('#menu').before($(formLabel('menu')).text('Nama Menu'))

		const id = $(this).data("id");

		$.ajax({
			url: base_url + "menu/getEditMenu/" + id,
			method: "post",
			data: {
				id: id
			},
			dataType: "json",
			success: function (data) {
				$("#id").val(data.id);
				$("#menu").val(data.menu);
			}
		});
    });

	// -------------------------------------------------------------------------------------//
    
    // SCRIPT UNTUK EDIT USER AKSES LEVEL
	$(".form-check-input").on("click", function () {
		console.log('ok');
		const menuId = $(this).data("menu");
		const roleId = $(this).data("role");
		console.log(menuId)
		console.log(roleId)

		$.ajax({
			url: base_url + "admin/changeaccess",
			type: "post",
			data: {
				menuId: menuId,
				roleId: roleId
			},
			success: function () {
				document.location.href = base_url + "admin/akseslevel/" + roleId;
			}
		});
	});

	// -------------------------------------------------------------------------------------//

	// SCRIPT UNTUK EDIT USER 
	$(".editUserLevel").on("click", function () {
		const id = $(this).data("id");

		$.ajax({
			url: base_url + "admin/edituser/" + id,
			method: "post",
			data: {
				id: id
			},
			dataType: "json",
			success: function (data) {
				$("#edit-id").val(data.id);
				$("#edit-nama").val(data.name);
				$("#edit-level_id").val(data.role_id);
			}
		});
	});
	// -------------------------------------------------------------------------------------//

	// SCRIPT UNTUK TAMBAH USER MENU

	$(".tambahMenu").on("click", function () {
		$("#newMenuModalLabel").html("Tambah Menu");
		$(".modal-footer button[type=submit]").html("Tambah");
		$(".modal-body form").attr("action", base_url + "menu");

		$('#menu').val('');
		$('[for = menu]').remove();
	});

	// -------------------------------------------------------------------------------------//


	// SCRIPT UNTUK MODAL TAMBAH SUBMENU

	$(".tambahSubmenu").on("click", function () {
		$("#newMenuModalLabel").html("Tambah Submenu");
		$(".modal-footer button[type=submit]").html("Tambah");
		$(".modal-content form").attr(
			"action",
			base_url + "menu/submenu"
		);
		for (let i = 0; i < attrSubmenu.length; i++) {
			$("[for = '" + attrSubmenu[i] + "']").remove();
		}

		for (let i = 0; i < attrSubmenu.length; i++) {
			$('#' + attrSubmenu[i]).val('');
		}
	});

	//-------------------------------------------------------------------------------------//


	// SCRIPT UNTUK MODAL UBAH SUBMENU

	$(".ubahSubmenu").on("click", function () {
		console.log('ok')
		$("#newSubMenuModalLabel").html("Ubah Submenu");
		$(".modal-footer button[type=submit]").html("Ubah");
		$(".modal-content form").attr("action", base_url + "menu/editSubmenu");

		for (let i = 0; i < attrSubmenu.length; i++) {
			$('#' + attrSubmenu[i]).before($(formLabel('' + attrSubmenu[i])).text(formLabelSubmenu[i]));
		}

		const id = $(this).data("id");

		$.ajax({
			url: base_url + "menu/getEditSubMenu/" + id,
			method: "post",
			data: {
				id: id
			},
			dataType: "json",
			success: function (data) {
				$("#id").val(data.id);
				$("#judul").val(data.title);
				$("#menu_id").val(data.menu_id);
				$("#url").val(data.url);
				$("#ikon").val(data.icon);
				$("#is_active").val(data.is_active);
			}
		});
	});

	// -------------------------------------------------------------------------------------//

	// SCRIPT NTUK TAMBAH PENDUDUK

	$(".tambahPenduduk").on("click", function () {
		$("#newPendudukLabel").html("Tambah Penduduk");
		$(".modal-footer button[type=submit]").html("Tambah");
		$(".modal-content form").attr(
			"action",
			base_url + "penduduk"
		);

		for (let i = 0; i < attrPenduduk.length; i++) {
			$("[for = '" + attrPenduduk[i] + "']").remove();
		}

		for (let i = 0; i < attrPenduduk.length; i++) {
			$('#' + attrPenduduk[i]).val('');
		}

	});

	// -------------------------------------------------------------------------------------//


	// SCRIPT NTUK TAMBAH PENDUDUK

	$(".ubahPenduduk").on("click", function () {
		$("#newPendudukLabel").html("Ubah Penduduk");
		$(".modal-footer button[type=submit]").html("Ubah");
		$(".modal-content form").attr(
			"action",
			base_url + "penduduk/ubahPenduduk"
		);

		const id = $(this).data("id");

		for (let i = 0; i < attrPenduduk.length; i++) {
			$('#' + attrPenduduk[i]).before($(formLabel(attrPenduduk[i])).text(formLabelPenduduk[i]));
		}

		$.ajax({
			url: base_url + "penduduk/getEditPenduduk/" + id,
			method: "post",
			data: {
				id: id
			},
			dataType: "json",
			success: data => {
				$("#id").val(data.id_penduduk);
				$("#nik").val(data.nik);
				$("#no_ktp").val(data.no_ktp);
				$("#nama").val(data.nama);
				$("#tmpt_tgl_lahir").val(data.tmpt_tgl_lahir);
				$("#agama").val(data.agama_id);
				$("#pekerjaan").val(data.pekerjaan);
				$("#alamat").val(data.alamat);
				$("#dusun").val(data.dusun_id);
				$("#rt").val(data.rt);
				$("#rw").val(data.rw);
				$("#jk").val(data.jk);
				$("#kewarganegaraan").val(data.kewarganegaraan);
				$("#sts_kawin").val(data.sts_kawin);
				$("#pendidikan").val(data.pendidikan_id);
				$("#suku").val(data.suku);
			}
		});
	});

	// -------------------------------------------------------------------------------------//




</script>

</body>

</html>