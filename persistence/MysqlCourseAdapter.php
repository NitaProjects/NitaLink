<?php

declare(strict_types=1);

include '../model/stakeholders/Course.php';
include 'MySQLAdapter.php';

class MysqlCourseAdapter extends MysqlAdapter {

    public function getCourse(int $courseId): Course {
        $data = $this->readQuery("SELECT courseId, name, price, quantity, duration, instructor, language FROM courses WHERE courseId = " . $courseId . ";");
        if (count($data) > 0) {
            return new Course($data[0]["name"], (float) $data[0]["price"], (int) $data[0]["courseId"], (int) $data[0]["quantity"],
                              (int) $data[0]["duration"], $data[0]["instructor"], $data[0]["language"]);
        } else {
            throw new ServiceException("No Course found with courseId = " . $courseId);
        }
    }

    public function deleteCourse(int $courseId): bool {
        try {
            return $this->writeQuery("DELETE FROM courses WHERE courseId = " . $courseId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error deleting the course " . $courseId . "-->" . $ex->getMessage());
        }
    }

    public function addCourse(Course $c): bool {
        try {
            return $this->writeQuery("INSERT INTO courses (courseId, name, price, quantity, duration, instructor, language) VALUES (" . 
                    $c->getCourseId() . ", \"" . $c->getName() . "\", " . $c->getPrice() . ", " . $c->getQuantity() . ", " . 
                    $c->getDuration() . ", \"" . $c->getInstructor() . "\", \"" . $c->getLanguage() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error inserting course -->" . $ex->getMessage());
        }
    }

    public function updateCourse(Course $c): bool {
        try {
            return $this->writeQuery("UPDATE courses SET name = \"" . $c->getName() . "\", price = " . $c->getPrice() . 
                    ", quantity = " . $c->getQuantity() . ", duration = " . $c->getDuration() . 
                    ", instructor = \"" . $c->getInstructor() . "\", language = \"" . $c->getLanguage() . 
                    "\" WHERE courseId = " . $c->getCourseId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error updating course -->" . $ex->getMessage());
        }
    }
}

