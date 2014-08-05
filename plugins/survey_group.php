<?php

class SurveyGroupAud {

    private $id;
    private $type;
    private $spec;

    public function __construct( $survey_id, $type, $spec ) {
        $this->id = $survey_id;
        $this->type = $type;
        $this->spec = $spec;
    }

    public function getAudience() {
        // connection
        $conn = connectionObject();

        switch( $this->type ) {

            case 1:
                // return all users
                $sql = 'SELECT * FROM users';
                $qry = $conn->prepare( $sql );
                $qry->execute();
                break;

            case 2:
                // return user between age range
                $sql = 'SELECT * FROM users WHERE age > ? AND age < ?';
                $qry = $conn->prepare( $sql );
                $qry->execute( array( $this->spec[0], $this->spec[1] ) );
                break;

            case 3:

               // $genders = "'" . implode( "','", $this->spec ) . "'" ;

                // return users of specific gender
                $sql = 'SELECT * FROM users WHERE gender IN (?, ?)';
                $qry = $conn->prepare( $sql );
                $qry->execute( array( $this->spec[0], $this->spec[1] ) );
                break;
        }
        return $qry->fetchAll(PDO::FETCH_ASSOC);
    }
}
