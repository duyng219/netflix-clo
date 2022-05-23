<?php
class CategoryContainers {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function showAllCategories() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        return $html . "</div>";
    }

    private function getCategoryHtml($sqlData, $title, $tvShows, $movies) {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;

        if($tvShows && $movies) {
            $enntities = EntityProvider::getEntities($this->con, $categoryId
            , 30);
        } else if ($tvShows) {
            // Get tv show entities
        } else {
            // Get movie entities
        }

        if(sizeof($enntities) == 0) {
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($enntities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return $entitiesHtml . "</br>";
    }
}
?>