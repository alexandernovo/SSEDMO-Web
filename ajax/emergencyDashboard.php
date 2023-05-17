<?php
require_once('../config/config.php');

// $emergency = find_where('emergency', ['status' => 0]);
$emergency = joinTableWherein('emergency', [['users', 'emergency.id', 'users.id'], ['room', 'room.room_id', 'emergency.room_id'], ['building', 'room.building_id', 'building.building_id']], ['emergency.status' => [0, 1]]);

if (!empty($emergency)) :
    foreach ($emergency as $result) : ?>
        <div class="col-md-3 mb-2">
            <div class="card bg-dark shadow border-0 card-radius">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-3 d-flex justify-content-center col-3 <?php echo $result['emergency_level'] == 1 ? "bg-primary" : ($result['emergency_level'] == 2 ? "bg-success" : ($result['emergency_level'] == 3 ? "bg-yellow" : ($result['emergency_level'] == 4 ? "bg-warning" : ($result['emergency_level'] == 5 ? "bg-danger" : "")))) ?> bg-gradient p-2 py-3 card-radius align-items-center">
                            <i class="fa fa-warning text-light pulse" style="font-size:17px"></i>
                        </div>
                        <div class="">
                            <h6 class="h6 text-end text-light"><?= $result['name'] ?></h6>
                            <p class="m-0 text-secondary">
                                <?= $result['building_name'] ?>
                                <?= $result['room_num'] ?>
                            </p>
                            <p class="m-0 text-secondary">
                                <?= $result['building_location'] ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 d-flex align-items-center justify-content-between">
                    <p class="m-0 <?php echo $result['emergency_level'] == 1 ? "text-primary" : ($result['emergency_level'] == 2 ? "text-success" : ($result['emergency_level'] == 3 ? "text-yellow" : ($result['emergency_level'] == 4 ? "text-warning" : ($result['emergency_level'] == 5 ? "text-danger" : "")))) ?> text-start" style="font-size:13px">
                        <i class="fa fa-warning"></i>
                        <i><?php echo $result['emergency_level'] == 1 ? "Minor Injury" : ($result['emergency_level'] == 2 ? "Moderate Injury" : ($result['emergency_level'] == 3 ? "Serious Injury" : ($result['emergency_level'] == 4 ? "Critical Situation" : ($result['emergency_level'] == 5 ? "Life-Threatening" : "")))) ?>
                        </i>
                    </p>
                    <p class="text-warning m-0 countdown" id="countdown" time-count="<?php echo $result['emergency_date'] ?>"></p>
                </div>
            </div>
        </div>

<?php endforeach;
endif;
?>