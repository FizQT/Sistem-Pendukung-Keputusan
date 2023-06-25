<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Kriteria extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->library('form_validation');
            $this->load->model('Kriteria_model');
			$this->load->library(array('excel','session'));

            if ($this->session->userdata('id_user_level') != "1") {
            ?>
				<script type="text/javascript">
                    alert('Anda tidak berhak mengakses halaman ini!');
                    window.location='<?php echo base_url("Login/home"); ?>'
                </script>
            <?php
			}
        }

        public function index()
        {
            $data['page'] = "Kriteria";
			$data['list'] = $this->Kriteria_model->tampil();
            $this->load->view('kriteria/index', $data);
        }
        
        public function import_excel(){
			if (isset($_FILES["fileExcel"]["name"])) {
				$path = $_FILES["fileExcel"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();	
					for($row=2; $row<=$highestRow; $row++)
					{
						$kode_kriteria = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$nama_kriteria = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$bobot = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$jenis = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$prioritas = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						
						$data[] = array(
							'nama_kriteria' => $nama_kriteria,
							'kode_kriteria' => $kode_kriteria,
							'bobot' => $bobot,
							'jenis' => $jenis,
							'prioritas' => $prioritas,
						);
					}
				}
				$insert = $this->Kriteria_model->insert_import($data);
				if($insert){
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil di Import ke Database!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi Kesalahan!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				echo "Tidak ada file yang masuk";
			}
		}
		
		
        public function create()
        {
			$data['page'] = "Kriteria";
            $this->load->view('kriteria/create', $data);
        }

        //menambahkan data ke database
        public function store()
        {
			$data = [
				'nama_kriteria' => $this->input->post('nama_kriteria'),
				'kode_kriteria' => $this->input->post('kode_kriteria'),
				'jenis' => $this->input->post('jenis'),
				'prioritas' => $this->input->post('prioritas')
			];
			
			$this->form_validation->set_rules('nama_kriteria', 'Nama', 'required');
			$this->form_validation->set_rules('kode_kriteria', 'Kode Kriteria', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('prioritas', 'Prioritas', 'required');

			

			if ($this->form_validation->run() != false) {
				$result = $this->Kriteria_model->insert($data);
				if ($result) {
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>');
					redirect('Kriteria');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>');
				redirect('Kriteria/create');
				
			}
        }
		
		public function generate()
        {
            $kriteria = $this->Kriteria_model->tampil();
			foreach ($kriteria as $x){
				$total = count($kriteria);
				$b = 0;
				foreach ($kriteria as $y){
					if($y->prioritas >= $x->prioritas){
						$b += 1/$y->prioritas;
					}
				}
				$id_kriteria = $x->id_kriteria;
				$bobot = number_format($b/$total,3);
				$data = array(
					'bobot' => $bobot,
				);
				$this->Kriteria_model->update_bobot($id_kriteria, $data);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data nilai bobot berhasil digenerate!</div>');
			redirect('kriteria');
        }

        public function edit($id_kriteria)
        {
            $data['page'] = "Kriteria";
			$data['kriteria'] = $this->Kriteria_model->show($id_kriteria);
            $this->load->view('kriteria/edit', $data);
        }
    
        public function update($id_kriteria)
        {
            // TODO: implementasi update data berdasarkan $id_kriteria
            $id_kriteria = $this->input->post('id_kriteria');
            $data = array(
                'nama_kriteria' => $this->input->post('nama_kriteria'),
                'kode_kriteria' => $this->input->post('kode_kriteria'),
                'jenis' => $this->input->post('jenis'),
				'prioritas' => $this->input->post('prioritas')
            );

            $this->Kriteria_model->update($id_kriteria, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>');
			redirect('kriteria');
        }
    
        public function destroy($id_kriteria)
        {
            $this->Kriteria_model->delete($id_kriteria);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
			redirect('kriteria');
        }
    
    }
    