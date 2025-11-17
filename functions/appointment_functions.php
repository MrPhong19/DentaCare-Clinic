<?php
// functions/appointment_functions.php

function createAppointment($pdo, $data) {
    $sql = "INSERT INTO appointments 
            (patient_name, patient_email, patient_phone, appointment_date, note, department, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['appointment_datetime'],
        $data['reason'] ?? '',
        $data['department']
    ]);
}

function isTimeSlotTaken($pdo, $datetime) {
    $stmt = $pdo->prepare("SELECT id FROM appointments WHERE appointment_date = ?");
    $stmt->execute([$datetime]);
    return $stmt->rowCount() > 0;
}