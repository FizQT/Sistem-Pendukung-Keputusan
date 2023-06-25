<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Kriteria_model extends CI_Model {

        public function tampil()
        {
            $query = $this->db->query("SELECT * FROM kriteria ORDER BY prioritas ASC");
            return $query->result();
        }

        public function insert_import($data){
			$insert = $this->db->insert_batch('kriteria', $data);
			if($insert){
				return true;
			}
		}


        public function insert($data = [])
        {
            $result = $this->db->insert('kriteria', $data);
            return $result;
        }

        public function show($id_kriteria)
        {
            $this->db->where('id_kriteria', $id_kriteria);
            $query = $this->db->get('kriteria');
            return $query->row();
        }

        public function update($id_kriteria, $data = [])
        {
            $ubah = array(
                'nama_kriteria' => $data['nama_kriteria'],
                'kode_kriteria' => $data['kode_kriteria'],
                'jenis'  => $data['jenis'],
				'prioritas'  => $data['prioritas']
            );

            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->update('kriteria', $ubah);
        }
		
		public function update_bobot($id_kriteria, $data = [])
        {
            $ubah = array(
                'bobot' => $data['bobot']
            );

            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->update('kriteria', $ubah);
        }

        public function delete($id_kriteria)
        {
            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->delete('kriteria');
        }
    }
    