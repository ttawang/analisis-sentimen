<?php


namespace App\Controllers;
use App\Models\tweet;

class Prepcontrol extends BaseController
{
	public function nourl($data){

		$regex1 = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
		$data = preg_replace($regex1, '',$data);
		return $data;
		/* 
		penghilangan url menggunakan regex, semua kalimat dan angka setelah https akan dihilangkan
		fungsi regex tersebut didapatkan melalui website/google
		*/
	}

	public function nousername($data){
		$regex2 = "/@\w+/"; #kalimat setelah at dihilangkan
		$data = preg_replace($regex2, '',$data);
		return $data;
		/* 
		penghilangan username menggunakan regex, semua kalimat dan angka setelah @ akan dihilangkan
		fungsi regex tersebut didapatkan melalui website/google
		*/
	}

	public function casefolding($data){
		$data = strtolower($data);
		return $data;
		/* 
		mengubah semua karakter menjadi huruf kecil menggunakan fungsi php strlower
		*/
	}

	public function stopword($data){
		$db = \Config\Database::connect();
		$stopwordlist = $db->table('stopwordlist')->get();	
		foreach($stopwordlist->getResult() as $j){

			#tokenizing
			$words = explode(' ',$data);
			/* 
			memecah kalimat berdasarkan space menggunakan fungsi explode pada php
			*/
			foreach($words as $k=>$value){

				#menghapus karakter tidak penting
				$regex3 = "/[^a-zA-Z0-9_]/";
				$words[$k] = preg_replace($regex3, '',$words[$k]);
				$words[$k] = preg_replace('/\d+/u', '', $words[$k]);
				/* 
				menghapus karakter tidak penting seperti angka dan tanda baca
				fungsi regex tersebut didapatkan melalui website/google
				*/

				if(strcmp($words[$k],$j->kata)==0){
					unset($words[$k]);
					/* 
					menghapus sebuah kata yang terdapat didalam database stopword
					*/
				}
				
			}
			$data = join(' ',$words);
		}
		return $data;
	}
	public function tokenizing($data){
		$word = explode(' ',$data);
		$word = array_filter(array_map('trim', $word));
		$data = join(' | ', $word);

		return $data;
		/* 
		memisahkan kalimat menggunakan tanda | untuk mengetahui setiap kalimat yang terdapat pada database
		*/
	}

	public function stemming($data){
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$data = $stemmer->stem($data);
		return $data;
		/* 
		stemming menggunakan library
		library yang digunkan sudah tertera pada proposal
		*/
	}

	public function tfidf(){
		
		$tweet = new tweet();
		$dataarr = []; #$a=0;
		$term = []; #membagi term pada setiap data (array 2D)
		

		foreach($tweet->findAll() as $i){
			$data = $i['kalimat'];
			$data = $this->nourl($data);
			$data = $this->nousername($data);
			$data = $this->casefolding($data);
			$data = $this->stopword($data);
			$data = $this->stemming($data);
			
			$dataarr[$i['id']] = $data;
			$term[$i['id']] = explode(' ',$data);
			
			#$a++;
		}
		$allterm = join(' ',$dataarr); #menambahkan seluruh data untuk pembgaian term
		$allterm = explode(' ',$allterm); #membagi per term
		$allterm = array_unique($allterm); #semua term tanpa duplikat
		$allterm = array_values($allterm); #reset index
		#print_r($allterm);
		
		#mencari tf
		$tf = [];
		foreach($allterm as $i => $value){
			foreach($term as $j => $value){
				$sum = 0;
				foreach($term[$j] as $k => $value){
					if(strcmp($allterm[$i],$term[$j][$k])==0){
						$sum++;
					}
				}
				$tf[$i][$j] = $sum;
			}	
		}
		
		#mencari df
		$idf = [];
		foreach($tf as $i => $value){
			$sum = 0;
			foreach($tf[$i] as $j => $value){
				if($tf[$i][$j]>0){
					$sum = $sum + 1;
				}
			$idf[$i] = $sum;
			}
		}

		#mencari idf+1
		foreach($idf as $i => $value){
			$idf[$i] = 1+(abs(log10($idf[$i] / count($dataarr))));
		}
		
		#mencari tfidf
		$tfidf = [];
		foreach($tf as $i => $value){
			foreach($tf[$i] as $j => $value){
				$tfidf[$i][$j] = $tf[$i][$j] * $idf[$i];
			}
		}
		#hasil bobot setiap dokumen
		$doc = [];
		foreach($tfidf as $i => $value){
			foreach($tfidf[$i] as $j => $value){
				$doc[$j][$i] = $tfidf[$i][$j];
			}
		}
		
		$hasil = [];
		foreach($doc as $i => $value){
			$temp = 0;
			foreach($doc[$i] as $j => $value){
				$temp = $temp + ($doc[$i][$j]**2);
			}
			$hasil[$i] = $temp;
		}
		
		
		return $hasil;
	}
	

	public function euclidean(){

		$tfidf = $this->tfidf();

		$euclidean = [];
		foreach($tfidf as $i => $value){
			foreach($tfidf as $j => $value){
				if($j!=$i){
					$euclidean[$i][$j] = sqrt($tfidf[$i]+$tfidf[$j]);
				}
				else{
					$euclidean[$i][$j] = 0;
				}
			}
		}
		$arr1 = $euclidean;
		file_put_contents("euclidean.json",json_encode($arr1));
		#return $euclidean;
	}

	public function ket(){
		$ket = [];#array keterangan positif negatif
		$tweet = new tweet();
		#penempatan keterangan 0/1 tweet pada array
		foreach($tweet->findAll() as $i){
			$ket[$i['id']] = $i['ket'];
		}
		return $ket;
	}

	public function max($arr, $k){
		$max = [];
		$new = $arr;
		foreach($arr as $a => $value){
			$temp = $new[$a];
			array_multisort($temp,SORT_DESC);
			array_splice($temp, $k);
			$max[$a] = $temp;
		}
		
		return $max;
		/* 
		fungsi untuk mencari nilai terbesar pada sebuah array berdasarkan jumlah nilai 'k'
		array tersebut di sortir kemudian dipotong sejumlah nilai k
		*/
	}

	public function min($arr, $k){
		$min = [];
		$new = $arr;
		foreach($arr as $a => $value){
			$temp = $new[$a];
			foreach($temp as $x => $value){
				if($temp[$x] == 0){
					unset($temp[$x]);
				}
			}
			array_multisort($temp,SORT_ASC);
			array_splice($temp, $k);
			$min[$a] = $temp;
		}
		
		return $min;
		/* 
		fungsi untuk mencari nilai terkecil pada sebuah array berdasarkan jumlah nilai 'k'
		array tersebut di sortir kemudian dipotong sejumlah nilai k
		*/
	}
	
	public function validitas($k){

		#$euclidean = $this->euclidean();
		$euclidean = json_decode(file_get_contents('euclidean.json'), true);
		$min = $this->min($euclidean, $k);
		
		$validitas = [];#array validitas
		#$min = [];#array nilai terkecil
		$ket = $this->ket();
		
		foreach($euclidean as $i => $value){
			$tot = 0;
			
			foreach($min[$i] as $j => $value){
				$key = array_search($min[$i][$j], $euclidean[$i]);
				$tot = $tot + $ket[$key];
			}
			$validitas[$i] = (1/$k) * ($tot);	
		}
		return $validitas;
		/* 
		nilai validitas diporeh berdasarkan label positif atau negatif dari nilai tetangga terdekat
		*/
	}


	public function weight($k){
		$weight = [];
		$ket = $this->ket();
		$validitas = $this->validitas($k);
		#$euclidean = $this->euclidean();
		$euclidean = json_decode(file_get_contents('euclidean.json'), true);
		$uji = round(count($ket)*20/100);#jumlah data uji
		$train = count($ket)-$uji;#jumlah data train

		#manipulasi index data uji
		$iuji = $ket; #temp index
		$ind = array_keys($iuji); #pembentukan index data uji
		$ind = array_slice($ind, $train); #pemotongan index untuk data uji berdasarkan data train
		
		
		for ($i = 0; $i < $uji ; $i ++){
			$temp[0] = []; #array weight voting keseluruhan
			foreach($euclidean as $j => $value){
				if($j < $ind[0]){
					$temp[0][$j] = $validitas[$j]*(1/($euclidean[$j][$ind[$i]]+0.5));		
				}	
			}
			$all = $temp[0]; 
			$max = $this->max($temp, $k);#array weight voting nilai tertinggi
			$x = $max[0];
			$nilai = 0;
			foreach($x as $l => $value){
				$key = array_search($x[$l], $all);
				$nilai = $nilai + $ket[$key];
			}
			$weight[$ind[$i]] = $nilai;
		}
		
		return $weight;
	}
	
	public function mknn($k){
		
		$weight = $this->weight($k);
		$mknn = [];
		foreach($weight as $i => $value){
			if($weight[$i] < round($k/2)){
				$mknn[$i] = 0; #positif
			}
			else{
				$mknn[$i] = 1; #negatif
			}
		}
		return $mknn;
		/* 
		
		*/
	}

	public function knn($k){
		$knn = [];#array validitas
		$ket = $this->ket();
		#$euclidean = $this->euclidean();
		$euclidean = json_decode(file_get_contents('euclidean.json'), true);
		$uji = round(count($ket)*20/100);#jumlah data uji
		$train = count($ket)-$uji;#jumlah data train

		#manipulasi index data uji
		$iuji = $ket; #temp index
		$ind = array_keys($iuji); #pembentukan index data uji
		$ind = array_slice($ind, $train); #pemotongan index untuk data uji berdasarkan data train
		
		
		$jarak = $this->min($euclidean, $k); #jarak terdekat
		
		foreach($ind as $i => $value){
			$nilai = 0;
			foreach($jarak[$ind[$i]] as $j => $value){
				$nilai = $nilai + $ket[array_search($jarak[$ind[$i]][$j], $euclidean[$ind[$i]])];
			}
			if($nilai < round($k/2)){
				$knn[$ind[$i]] = 0; #positif
			}
			else{
				$knn[$ind[$i]] = 1; #negatif
			}
		}
		
		return $knn;
		
	}
	public function hasilknn($k){
		#0 = positif
		#1 = negatif

		$ket = $this->ket();
		$knn = $this->knn($k);
	
		$tp = 0; #true positif
		$tn = 0; #true negatif
		$fp = 0; #false positif
		$fn = 0; #false negatif
		foreach($knn as $i => $value){
			if($knn[$i] == 0 && $ket[$i] == 0){
				$tp++;
			}
			else if($knn[$i] == 1 && $ket[$i] == 0){
				$fn++;
			}
			else if($knn[$i] == 0 && $ket[$i] == 1){
				$fp++;
			}
			else if($knn[$i] == 1 && $ket[$i] == 1){
				$tn++;
			}
		}

		#Akurasi = (TP + TN ) / (TP+FP+FN+TN)
		$akurasi = ($tp + $tn) / ($tp + $fp + $fn + $tn);
		#Precission = (TP) / (TP+FP)
		if($tp != 0){
			$precission = ($tp) / ($tp + $fp);
		}
		else{
			$precission = 0;
		}
		#Recall = (TP) / (TP + FN)
		$recall = ($tp) / ($tp + $fn);

		$hasilknn = [$akurasi*100, $precission*100, $recall*100,$knn];;
		
		return $hasilknn;
	}

	public function hasilmknn($k){
		#0 = positif
		#1 = negatif

		$ket = $this->ket();
		$mknn = $this->mknn($k);
		
		$tp = 0; #true positif
		$tn = 0; #true negatif
		$fp = 0; #false positif
		$fn = 0; #false negatif
		foreach($mknn as $i => $value){
			if($mknn[$i] == 0 && $ket[$i] == 0){
				$tp++;
			}
			else if($mknn[$i] == 1 && $ket[$i] == 0){
				$fn++;
			}
			else if($mknn[$i] == 0 && $ket[$i] == 1){
				$fp++;
			}
			else if($mknn[$i] == 1 && $ket[$i] == 1){
				$tn++;
			}
		}

		#Akurasi = (TP + TN ) / (TP+FP+FN+TN)
		$akurasi = ($tp + $tn) / ($tp + $fp + $fn + $tn); 

		#Precission = (TP) / (TP+FP)
		if($tp != 0){
			$precission = ($tp) / ($tp + $fp);
		}
		else{
			$precission = 0;
		}
		#Recall = (TP) / (TP + FN)
		$recall = ($tp) / ($tp + $fn);

		$hasilmknn = [$akurasi*100, $precission*100, $recall*100,$mknn];
		
		return $hasilmknn;
	}
	
}
