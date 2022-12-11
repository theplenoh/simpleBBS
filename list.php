<?php
require_once "common.php";
require_once $path."db_connect.php";

$page_size = 10;
$page_list_size = 10;

if (!isset($_GET['no']) || $_GET['no'] < 0)
    $no = 0;
else
    $no = $_GET['no'];

// 데이터베이스에서 페이지의 첫 번째 글($no)부터 $page_size만큼의 글을 가져온다.
$query = "SELECT * FROM {$board_name} ORDER BY post_id DESC LIMIT {$no}, {$page_size}";
$result = mysqli_query($conn, $query);

// 총 게시물 수를 구한다.
$result_count = mysqli_query($conn, "SELECT COUNT(*) FROM {$board_name};");
$total_row = mysqli_fetch_row($result_count)[0];

// 총 페이지 계산
if ($total_row <= 0)
    $total_row = 0;

$total_page = ceil($total_row / $page_size);

// 현재 페이지 계산
$current_page = ceil(($no+1) / $page_size);
// 1($current_page) = ceil(( 0($no) + 1) / 10($page_size)) // 1 == ceil(0.1)
// 2($current_page) = ceil((10($no) + 1) / 10($page_size)) // 2 == ceil(1.1)
// 3($current_page) = ceil((20($no) + 1) / 10($page_size)) // 3 == ceil(2.1)
// ...
// 5($current_page) = ceil((40($no) + 1) / 10($page_size)) // 5 == ceil(4.1)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?=$charset?>">
    <title><?=$board_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?=$path?>style.css">
</head>

<body>
<div id="wrap">
<h1><?=$board_title?></h1>
<pre>
<?php
echo "Total rows: {$total_row}\n";
echo "Total pages: {$total_page}\n";
echo "Current page: {$current_page}\n";
echo "\$current_page = ceil(({$no}(\$no) + 1) / {$page_size}(\$page_size))\n";
?>
</pre>
<main>
<table>
<thead>
    <tr>
        <th class="no" scope="col">No.</th>
        <th class="title" scope="col">Title</th>
        <th class="posted-by" scope="col">Posted by</th>
        <th class="date" scope="col">Date</th>
        <th class="views" scope="col">Views</th>
    </tr>
</thead>
<tbody>
<?php
if ($total_row <= 0)
{
?>
    <tr>
        <td colspan="5">There are no posts.</td>
    </tr>
<?php
}
else
{
    while($row = mysqli_fetch_array($result))
    {
?>
    <tr>
        <td>
            <?=$row['post_id']?>
        </td>
        <td>
            <a href="<?=$path?>view.php?post_id=<?=$row['post_id']?>&no=<?=$no?>">
                <?=strip_tags($row['title'], '<b><i>');?>
            </a>
        </td>
        <td>
<?php
if ($row['email']!="")
{
?>
            <a href="mailto:<?=$row['email']?>"><?=$row['name']?></a>
<?php
}
else
{
?>
            <?=$row['name']?>
<?php
}
?>
        </td>
        <td>
            <?=substr($row['wdate'], 0, 10)?>
        </td>
        <td>
            <?=$row['views']?>
        </td>
    </tr>
<?php
    }
}
mysqli_close($conn);
?>
</tbody>
</table>
<p class="pagination">
<?php
$start_page = floor(($current_page - 1) / $page_list_size) * $page_list_size + 1;
//            floor((     3        - 1) / 10             ) *       10        + 1;
//            floor(                 0.2                 ) *       10        + 1;
//                                   0                     *       10        + 1;
//                                                         0                 + 1;
//                                                                             1;

//            floor((     10       - 1) / 10             ) *       10        + 1;
//            floor(                 0.9                 ) *       10        + 1;
//                                   0                     *       10        + 1;
//                                                         0                 + 1;
//                                                                             1;

//            floor((     11       - 1) / 10             ) *       10        + 1;
//            floor(                 1                   ) *       10        + 1;
//                                   1                     *       10        + 1;
//                                                        10                 + 1;
//                                                                            11;

//            floor((     21       - 1) / 10             ) *       10        + 1;
//            floor(                 2                   ) *       10        + 1;
//                                   2                     *       10        + 1;
//                                                                            21;

//            floor((     25       - 1) / 10             ) *       10        + 1;
//            floor(                 2.4                 ) *       10        + 1;
//                                   2                     *       10        + 1;
//                                                                            21;

// 페이지 리스트의 마지막 페이지가 몇 번째 페이지인지 구하는 부분이다.
$end_page = $start_page + $page_list_size - 1;
//  10    =      1      +       10        - 1;
//  20    =      11     +       10        - 1;

if ($total_page < $end_page) // 총 페이지 수가 $page_list_size보다 적을 경우
    $end_page = $total_page; // 총 페이지 수를 끝 페이지에 넣는다



if ($start_page >= $page_list_size) // 시작 페이지가 $page_list_size 이상일 경우 // 즉, 두번째 페이지 부터일 경우
{
//  이전 페이지 리스트 값은 첫 번째 페이지에서 한 페이지 감소하면 된다.
//  $page_size를 곱해주는 이유는 글 번호로 표시하기 위해서이다.
    $prev_list = ($start_page - 2) * $page_size;
//  $prev_list = (     11     - 2) *     10
//  $prev_list = (            9  ) *     10
//  $prev_list($no) =              90

    echo "<a href=\"$_SERVER[PHP_SELF]?no=$prev_list\">◀</a>\n";
}

// 페이지 리스트를 출력
for ($i=$start_page; $i <= $end_page; $i++)
{
    $page = ($i - 1) * $page_size; // 페이지 값을 no값으로 변환
    if ($no != $page) // 현재 보는 페이지가 아니라면,
        echo " <a href=\"$_SERVER[PHP_SELF]?no=$page\">";

    echo "$i"; // 페이지를 표시

    if ($no != $page)
        echo "</a> ";
}

// 다음 페이지 리스트가 필요할때는 총 페이지가 마지막 리스트보다 클 때이다.
// 리스트를 다 뿌리고도 더 뿌려줄 페이지가 남았을 때 다음 버튼이 필요할 것이다.
if ($total_page > $end_page)
{
    $next_list = $end_page * $page_size;
    echo "<a href=\"$_SERVER[PHP_SELF]?no=$next_list\">▶</a>";
}
?>
</p>
<p class="buttons">
    <a class="btn" href="compose.php">Post</a>
</p>
</main>
</div>
</body>
</html>
