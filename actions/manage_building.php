<?php
require_once '../config/config.php';

if (isset($_POST['add_building'])) :

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post

        $building_name = $_POST['building_name'];
        $building_location = $_POST['building_location'];
        //Input the fields
        $fields = [
            'building_name' => $building_name,
            'building_location' => $building_location,
        ];
        //Create Validation if you want to see the choices ..go to database.php
        $validations = [
            'building_name' => [
                'required' => true,
                'unique' => [
                    'fieldName' => 'building_name',
                    'tableName' => 'building'
                ],
            ],
            'building_location' => [
                'required' => true,
            ]
        ];

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $data = [
                'building_name' => $building_name,
                'building_location' => $building_location
            ]; //put it in array before saving

            $save = save('building', $data); // $save = save('table_name', ['colum_name'=>$username]); if there is one data to save use this
            if ($save) {
                removeValue(); //remove the retain value in inputs
                setFlash('success', 'Added Successfully'); //set message
?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem("addbuildingmodal", false);
                        window.location.replace('../views/manage_place.php');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
            <?php
            } else {
                retainValue(); //retain value even if there is errors or refresh
                setFlash('failed', 'Add Failed'); //set message
                redirect('manage_place'); //shortcut for header('location:index.php ');
            }
        } else {
            retainValue(); //retain value even if there is errors or refresh
            returnError($errors);
            redirect('manage_place'); //shortcut for header('location:register.php?errors=$errors');
        }
    }

endif;

if (isset($_POST['update_building'])) :

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $building_id = $_POST['building_id'];
        $building_name = $_POST['building_name'];
        $building_location = $_POST['building_location'];

        $fields = [
            'building_name' => $building_name,
            'building_location' => $building_location,
        ];

        $validations = [
            'building_name' => [
                'required' => true,
                'unique' => [
                    'fieldName' => 'building_name',
                    'tableName' => 'building'
                ],
            ],
            'building_location' => [
                'required' => true
            ],
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {
            $update_building = update('building', ['building_id' => $building_id], ['building_name' => $building_name], ['building_location' => $building_location]);
            if ($update_building) {
                setFlash('success', 'Updated Successfully');
            ?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem('editbuildingmodal', false);
                        window.location.replace('../views/manage_place.php');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
<?php
                // redirect('manage_place');
            } else {
                setFlash('failed', 'Update Failed');
                redirect('manage_place');
            }
        } else {
            $errors['id'] = $building_id;
            returnError($errors);
            redirect('manage_place');
        }
    }

endif;
