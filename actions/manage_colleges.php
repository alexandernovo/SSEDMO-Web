<?php
require_once '../config/config.php';

if (isset($_POST['add_college'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $colleges_name = $_POST['colleges_name'];

        $fields = [
            'colleges_name' => $colleges_name,
        ];

        $validations = [
            'colleges_name' => [
                'required' => true,
                'unique' => [
                    'fieldName' => 'colleges_name',
                    'tableName' => 'colleges',
                ],
            ]
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {

            $data = [
                'colleges_name' => $colleges_name,
            ];

            $save = save('colleges', $data);

            if ($save) {
                setFlash('success', 'Added Successfully');
?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem("addColleges", false);
                        window.location.replace('../views/manageColleges.php');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
            <?php
            } else {
                setFlash('failed', 'Add Failed');
                redirect('manageColleges');
            }
        } else {
            returnError($errors);
            redirect('manageColleges');
        }
    }

endif;

if (isset($_POST['update_colleges'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $colleges_ID = $_POST['colleges_ID'];
        $colleges_name = $_POST['colleges_name'];

        $save = update('colleges', ['colleges_ID' => $colleges_ID], ['colleges_name' => $colleges_name]);

        if ($save) {
            setFlash('success', 'Updated Successfully');
            redirect('manageColleges');
        } else {
            setFlash('failed', 'Update Failed');
            redirect('manageColleges');
        }
    }
endif;

// add course

if (isset($_POST['add_course'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $course_name = $_POST['course_name'];
        $colleges_ID = $_POST['colleges_ID'];

        $fields = [
            'course_name' => $course_name,
        ];

        $validations = [
            'course_name' => [
                'required' => true,
                'unique' => [
                    'fieldName' => 'course_name',
                    'tableName' => 'course',
                ],
            ],
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {

            $data = [
                'course_name' => $course_name,
                'colleges_ID' => $colleges_ID,
            ];

            // $returnData = [
            //     'course_name' => $course_name,
            //     'colleges_ID' => $colleges_ID,
            // ];

            $save = save('course', $data);

            if ($save) {
                setFlash('success', 'Added Successfully');
            ?>
                <script>
                    //make the modal false in local storage so that it wont appear again when its successful
                    function saveToLocalStorageAndRedirect() {
                        localStorage.setItem("addCourse", false);
                        window.location.replace('../views/manageColleges.php');
                    }
                    saveToLocalStorageAndRedirect();
                </script>
<?php
            } else {
                setFlash('failed', 'Add Failed');
                redirect('manageColleges');
            }
        } else {
            returnError($errors);
            redirect('manageColleges');
        }
    }

endif;


if (isset($_POST['update_course'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $colleges_ID = $_POST['colleges_ID'];
        $course_name = $_POST['course_name'];
        $course_ID = $_POST['course_ID'];

        $save = update('course', ['course_ID' => $course_ID], ['colleges_ID' => $colleges_ID, 'course_name' => $course_name]);
        if ($save) {
            setFlash('success', 'Updated Successfully');
            redirect('manageColleges');
        } else {
            setFlash('failed', 'Update Failed');
            redirect('manageColleges');
        }
    }
// var_dump($_POST);
endif;
