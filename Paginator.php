<?php

class Paginator{
    private $request_url;
    private $per_page; //limit or the number of results to display per page
    //the current page
    private $page;
     //last page
     //calculate based on the number of rows found and the number of rows
     // display per page: $rows_found /$per_page (number of results to display per page)
    private $last_page;
    //will be generated using a for loop
    /*  while(i<$last){
        //1 2 3
        }
  <a href="pat_to_your_script.php&page=1>1</a>
  <a href="pat_to_your_script.php&page=2>2</a>
  <a href="pat_to_your_script.php&page=3>3</a> */
    private $row_found;
    private $pagination_links;

    public function __construct($rows_found, $per_page)
    {
        $this->rows_found = $rows_found;
        $this->per_page = $per_page;
        $this->last_page = ceil($rows_found/$per_page);
        $this->page = isset($_GET['page'])? $_GET['page'] : 1;
        $this->request_url = $this->get_request_path();
    }

    public function get_request_path()
    {
        return parse_url($_SERVER['REQUEST_URI'])['path'];
    }

    public function create_pagination_links()
    {
        for($page = 1; $page <= $this->last_page; $page++){
            $is_link_active ="";
            if($this->page == $page){
                $is_link_active ="active";
            }
            $this->pagination_links .= "
            <li class ='".$is_link_active."page-item'>
                 <a href=''>$page</a>
            </li>
            ";

        }
        echo $this->pagination_links;
    }

}