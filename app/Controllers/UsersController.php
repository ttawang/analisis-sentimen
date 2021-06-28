<?php namespace App\Controllers;

use App\Models\test;


class UsersController extends BaseController{

    public function index(){
      ## Fetch all records
        $users = new test();
        $data['users'] = $users->findAll();

        return view('users/index',$data);
    }

   // File upload and Insert records
    public function importFile(){

      // Validation
        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
        ]);

        if (!$input) { // Not valid
            session()->setFlashdata('message', 'File not imported.');
            session()->setFlashdata('alert-class', 'alert-danger');

            return redirect()->to('/test');
        }else{ // Valid
            if($file = $this->request->getFile('file')) {
                $db      = \Config\Database::connect();
                $builder = $db->table('test');
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
                            $importData_arr[$i]['name'] = $filedata[0];
                            $importData_arr[$i]['email'] = $filedata[1];
                            $importData_arr[$i]['city'] = $filedata[2];
                            $importData_arr[$i]['status'] = $filedata[3];

                        }

                        $i++;

                    }
                    fclose($file);
    
                    // Insert data
                    $count = 0;
                    foreach($importData_arr as $userdata){
                        $users = new test();

                        // Check record
                        $checkrecord = $users->where('email',$userdata['email'])->countAllResults();

                        if($checkrecord == 0){

                            ## Insert Record
                            if($users->insert($userdata)){
                                $count++;
                            }
                        }

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

        return redirect()->to('/test'); 
    }
}