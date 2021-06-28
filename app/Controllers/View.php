<?php

namespace App\Controllers;
use App\Controllers\Prepcontrol;
use App\Models\tweet;
use App\Models\k;

class View extends BaseController
{	
	public function prepare(){
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$ket = $prep->ket();
		
		
		$jmldata = $tweet->countAll(); #penghitungan jumlah data
		
		if($jmldata>0){
			$jmltest = round($jmldata*(20/100)); 
			$jmltrain = $jmldata - $jmltest; 
			$negatif = array_sum($prep->ket());
			$positif = $jmldata - $negatif;
			#manipulasi index data uji
			$itrain = $ket; #temp index
			$ind = array_keys($itrain); #pembentukan index data uji
			$ind = array_slice($ind, $jmltrain); #pemotongan index untuk data uji berdasarkan data train

			$data=[
				'jmldata' => $jmldata,
				'jmltrain' => $jmltrain,
				'jmltest' => $jmltest,
				'negatif' => $negatif,
				'positif' => $positif,
				'indtest' => $ind[0],
			];
		}
		else{
			$data=[
				'jmldata' => 0,
				'jmltrain' => 0,
				'jmltest' => 0,
				'negatif' => 0,
				'positif' => 0,
				'indtest' => 0,
			];
		}
		
		return $data;
	}
	
	public function home()
	{
		
		$tweet = new tweet();
		$k = new k();
		$data['k'] = $k->findAll();
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmltrain'] = $this->prepare()['jmltrain'];
		$data['jmltest'] = $this->prepare()['jmltest'];
		$data['negatif'] = $this->prepare()['negatif'];
		$data['positif'] = $this->prepare()['positif'];

		$data['tittle'] = 'Data Tweet';
		$data['tweet'] = $tweet->orderBy('id','desc')->findAll();
		$data['k'] = $k->findall();
		
		echo view('home',$data);
	}

	public function training()
	{
		$tweet = new tweet();
		$k = new k();
		$data['k'] = $k->orderBy('id','desc')->findAll();
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmltrain'] = $this->prepare()['jmltrain'];
		$data['jmltest'] = $this->prepare()['jmltest'];
		$data['negatif'] = $this->prepare()['negatif'];
		$data['positif'] = $this->prepare()['positif'];

		$indtest = $this->prepare()['indtest']; #index data test
		
		$data['tittle'] = 'Data Training';
		foreach($tweet->orderBy('id','desc')->findAll() as $a){
			if($a['id'] < $indtest ){
				$n = $a['id'];
				$data['kalimat'][$n] = $a['kalimat'];
				$data['tanggal'][$n] = $a['tanggal'];
				$data['ket'][$n] = $a['ket'];
			}
		}
		echo view('training',$data);
	}

	public function testing()
	{
		$tweet = new tweet();
		$k = new k();
		$data['k'] = $k->orderBy('id','desc')->findAll();
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmltrain'] = $this->prepare()['jmltrain'];
		$data['jmltest'] = $this->prepare()['jmltest'];
		$data['negatif'] = $this->prepare()['negatif'];
		$data['positif'] = $this->prepare()['positif'];
		$indtest = $this->prepare()['indtest']; #index data test

		$data['tittle'] = 'Data Testing';
		foreach($tweet->orderBy('id','desc')->findAll() as $a){
			if($a['id'] >= $indtest ){
				$n = $a['id'];
				$data['kalimat'][$n] = $a['kalimat'];
				$data['tanggal'][$n] = $a['tanggal'];
				$data['ket'][$n] = $a['ket'];
			}
		}
		
		echo view('testing',$data);
	}
	
	public function preprocessing(){
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$k = new k();
		$data['k'] = $k->orderBy('id','desc')->findAll();
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmltrain'] = $this->prepare()['jmltrain'];
		$data['jmltest'] = $this->prepare()['jmltest'];
		$data['negatif'] = $this->prepare()['negatif'];
		$data['positif'] = $this->prepare()['positif'];

		$data['tittle'] = 'Data Preprocessing';

		
		$n=0;
		foreach($tweet->orderBy('id','desc')->findAll() as $i){
			$kalimat[$n] = $i['kalimat'];
			$casefolding[$n] = $prep->casefolding($kalimat[$n]);
			$nourl[$n] = $prep->nourl($casefolding[$n]);
			$nousername[$n] = $prep->nousername($nourl[$n]);
			$tokenizing[$n] = $prep->tokenizing($nousername[$n]);
			$stopword[$n] = $prep->stopword($nousername[$n]);
			$stemming[$n] = $prep->stemming($stopword[$n]);
			$n++;
		}
		if($tweet->countAll()>0){
			$data['tweet'] = [
				'kalimat' => $kalimat,
				'case folding' => $casefolding,
				'nourl' => $nourl,
				'nousername' => $nousername,
				'tokenizing' => $tokenizing,
				'stopword' => $stopword,
				'stemming' => $stemming,
			];	
		}
		
		echo view('preprocessing',$data);

	}

	public function compare(){
		$prep = new Prepcontrol();
		$prep->euclidean();
		$k = new k();
		foreach($k->findAll() as $i){
			$q = intval($i['k']);
		}
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$data['k'] = $k->orderBy('id','desc')->findAll();
		$data['jmldata'] = $this->prepare()['jmldata'];
		$data['jmltrain'] = $this->prepare()['jmltrain'];
		$data['jmltest'] = $this->prepare()['jmltest'];
		$data['negatif'] = $this->prepare()['negatif'];
		$data['positif'] = $this->prepare()['positif'];
		$indtest = $this->prepare()['indtest']; #index data test

		foreach($tweet->orderBy('id','desc')->findAll() as $a){
			if($a['id'] >= $indtest){
				$n = $a['id'];
				$data['kalimat'][$n] = $a['kalimat'];
				$data['ket'][$n] = $a['ket'];
			}
		}

		$data['tittle'] = 'Data Compare';
		$data['hasilmknn'] = $prep->hasilmknn($q);
		$data['hasilknn'] = $prep->hasilknn($q);

		echo view('compare',$data);
	}
	public function add(){
		$k = new k();
		foreach($k->findAll() as $i){
			$q = intval($i['k']);
		}
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$data['k'] = $k->findAll();

		$data['tittle'] = 'do';
		
		$validation =  \Config\Services::validation();
		$validation->setRules(['kalimat' => 'required']);
		$isDataValid = $validation->withRequest($this->request)->run();

		if($isDataValid){
            $tweet = new tweet();
            $tweet->insert([
                "tanggal" => $this->request->getPost('tanggal'),
                "kalimat" => $this->request->getPost('kalimat'),
				"ket" => $this->request->getPost('ket'),
            ]);
            return redirect()->to('/home');
        }

		echo view('add',$data);
	}
	public function edit($id=0){
		$k = new k();
		foreach($k->findAll() as $i){
			$q = intval($i['k']);
		}
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$data['k'] = $k->findAll();

		$data['tittle'] = 'do';
		
		$tweet = new tweet();
		$data['tweet'] = $tweet->where('id', $id)->first();

		$validation =  \Config\Services::validation();
        $validation->setRules([
            'id' => 'required',
            'kalimat' => 'required'
        ]);
		$isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
        if($isDataValid){
            $tweet->update($id, [
                "tanggal" => $this->request->getPost('tanggal'),
                "kalimat" => $this->request->getPost('kalimat'),
				"ket" => $this->request->getPost('ket'),
            ]);
            return redirect()->to('/home');
        }

		echo view('edit',$data);
	}
	public function delete($id=0){
		$k = new k();
		foreach($k->findAll() as $i){
			$q = intval($i['k']);
		}
		$tweet = new tweet();
		$prep = new Prepcontrol();
		$data['k'] = $k->findAll();

        $tweet = new tweet();
        $tweet->delete($id);

        return redirect()->to('/home');
    }
	public function k($idn=3){
		$data['tittle'] = 'do';
		$tweet = new tweet();
		
		
		$k = new k();
		$data['kk'] = $k->where('id', $idn)->first();
		$data['k'] = $k->findAll();

		$validation =  \Config\Services::validation();
        $validation->setRules([
            'k' => 'required',
        ]);
		$isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
		if($tweet->countAll()>0){
			if($isDataValid){
				$k->update($idn, [
					"k" => $this->request->getPost('k'),
				]);
				return redirect()->to('/compare');
			}
		}
		else{
			return redirect()->to('/home');
		}
        

		echo view('k',$data);
    }

	public function importFile(){

		// Validation
		  $input = $this->validate([
			  'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
		  ]);
  
		  if (!$input) { // Not valid
			  session()->setFlashdata('message', 'File not imported.');
			  session()->setFlashdata('alert-class', 'alert-danger');
  
			  return redirect()->to('/home');
		  }else{ // Valid
			  if($file = $this->request->getFile('file')) {
				  $db      = \Config\Database::connect();
				  $builder = $db->table('tweet');
				  $builder->truncate();
				  if ($file->isValid() && ! $file->hasMoved()) {
  
					  // Get random file name
					  $newName = $file->getRandomName();
  
					  // Store file in public/csvfile/ folder
					  $file->move('../public/csvfile', $newName);
  
					  // Reading file
					  $file = fopen("../public/csvfile/".$newName,"r");
					  $i = 0;
					  $numberOfFields = 4; // Total number of fields
  
					  $importData_arr = array();
  
					  // Initialize $importData_arr Array
					  while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
						  $num = count($filedata);
  
						  // Skip first row & check number of fields
						  if($i > 0 && $num == $numberOfFields){ 
						  
							  // Key names are the insert table field names - name, email, city, and status
							  $importData_arr[$i]['id'] = $filedata[0];
							  $importData_arr[$i]['tanggal'] = $filedata[1];
							  $importData_arr[$i]['kalimat'] = $filedata[2];
							  $importData_arr[$i]['ket'] = $filedata[3];
  
						  }
  
						  $i++;
  
					  }
					  fclose($file);
	  
					  // Insert data
					  $count = 0;
					  foreach($importData_arr as $userdata){
						  $users = new tweet();
  
						  // Check record
						  $checkrecord = $users->where('ket',$userdata['ket'])->countAllResults();
  
						  #if($checkrecord == 0){
  
							  ## Insert Record
							  if($users->insert($userdata)){
								  $count++;
							  }
						  #}
  
					  }
  
					  // Set Session
					  session()->setFlashdata('message', $count.' Record inserted successfully!');
					  session()->setFlashdata('alert-class', 'alert-success');
  
				  }else{
				  // Set Session
					  session()->setFlashdata('message', 'File not imported.');
					  session()->setFlashdata('alert-class', 'alert-danger');
				  }
			  }else{
			  // Set Session
				  session()->setFlashdata('message', 'File not imported.');
				  session()->setFlashdata('alert-class', 'alert-danger');
				  }
  
		  }
  
		  return redirect()->to('/home'); 
	}
}
