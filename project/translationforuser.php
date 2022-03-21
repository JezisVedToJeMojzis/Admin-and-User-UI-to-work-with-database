<?php //used in user
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['search'])){

    $servername =  //add yours
    $username =  //add yours
    $password =  //add yours
    $dbname =  //add yours

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT 
                                        t1.title as searchTitle, 
                                        t1.description as searchDescription, 
                                        t2.title as translatedTitle, 
                                        t2.description as translatedDescription,
                                        t1.word_id
                                    FROM translations t1 
                                    JOIN translations t2
                                        ON t1.word_id = t2.word_id                                  
                                    JOIN languages 
                                        ON t1.language_id = languages.id 
                                    WHERE 
                                          languages.code = :language 
                                    AND 
                                          t1.title like :search 
                                    AND 
                                          t1.id <> t2.id");
        $search = "%".$_GET['search']."%";
        $stmt->bindParam(":search", $search); //PDO::STRING is set by default
        $stmt->bindParam(":language", $_GET['languageCode']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        echo json_encode($result);
    }
    catch (PDOException $e){
        echo "Error: ". $e->getmessage();
    }
}
