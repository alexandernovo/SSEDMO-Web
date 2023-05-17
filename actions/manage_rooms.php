<?php
require_once '../config/config.php';

if (isset($_POST['add_rooms'])) :

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $room_num = $_POST['room_num'];
        $building_id = $_POST['building_id'];
        $building_name = $_POST['building_name'];

        $fields = [
            'room_num' => $room_num,
        ];

        $validations = [
            'room_num' => [
                'required' => true,
            ]
        ];

        $errors = validate($fields, $validations);

        $returnData = [
            'building_id' =>  $building_id,
            'building_name' =>  $building_name,
        ];

        if (empty($errors)) {

            $data = [
                'room_num' => $room_num,
                'building_id' => $building_id,
            ];

            $save = save('room', $data);

            if ($save) {
                setFlash('success', 'Added Successfully');
?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem("addroommodal", false);
                        window.location.replace('../views/rooms.php?building_name=<?php echo $building_name; ?>&building_id=<?php echo $building_id; ?>');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
            <?php
            } else {
                setFlash('failed', 'Add Failed');
                redirect('rooms', $returnData);
            }
        } else {
            returnError($errors);
            redirect('rooms', $returnData);
        }
    }

endif;

if (isset($_POST['update_rooms'])) :

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $room_id = $_POST['room_id'];
        $room_num = $_POST['room_num'];
        $building_id = $_POST['building_id'];
        $building_name = $_POST['building_name'];
        $fields = [
            'room_num' => $room_num,
        ];

        $validations = [
            'room_num' => [
                'required' => true,
            ]
        ];

        $errors = validate($fields, $validations);

        $returnData = [
            'building_id' => $building_id,
            'building_name' => $building_name,
        ];

        if (empty($errors)) {
            $update = update('room', ['room_id' => $room_id], ['room_num' => $room_num]);
            if ($update) {
                setFlash('success', 'Updated Successfully');
            ?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem("editroommodal", false);
                        window.location.replace('../views/rooms.php?building_id=<?php echo $building_id; ?>&building_name=<?php echo $building_name ?>');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
<?php
            } else {
                setFlash('failed', 'Update Failed');
                redirect('rooms', $returnData);
            }
        } else {
            $errors['edit_room_id'] = $room_id;
            returnError($errors);
            redirect('rooms', $returnData);
        }
    }

endif;
