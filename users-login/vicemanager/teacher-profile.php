<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: vicemanager-login.php');
    exit;
}
$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM vice WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: vicemanager-login.php');
    exit;
}
$teacher_id = $_GET['id'];


$sql = "SELECT * FROM teacher_subject_class where teacher_id = $teacher_id AND deleted=0 ORDER BY class_id";
$result = mysqli_query($conn, $sql);
$records = array();
if (mysqli_num_rows($result) > 0) {
    while ($record = mysqli_fetch_assoc($result)) {
        $records[] = $record;
    }
}

$stmt = $conn->prepare("SELECT * FROM teacher where id = $teacher_id AND deleted=0");
$stmt->execute();
$result = $stmt->get_result();
$teacher = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="stylesheet" href="../manager/manager.css/manager-home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="../../images/logo/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="../../images/logo/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../../images/logo/favicon-16x16.png"
    />
    <link rel="manifest" href="/site.webmanifest" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
      crossorigin="anonymous"
    />

  </head>
  <body ng-controller="myController">
  <div ng-include="'../../views/headers/vice-manager-header.php'"></div>
    <section class="section add-sc" id="editpass">
      <h1 class="welcome">Teacher "<?php echo $teacher['first_name'] ;?>" Profile Details</h1>
      <article class="profile-article">
        <div class="teacher-details">
          <form>
        <div class="teacher-info">
        <label for="Email">
          <span>Email</span>
          <input type="text" name="email" id="email" value="<?php echo $teacher['email'] ;?>" readonly>
        </label>
        <label for="number">
          <span>Phone</span>
          <input type="tel" name="number" id="number" value="<?php echo $teacher['phone'] ;?>" readonly>
        </label>
        </div>
          <div class="teacher-actions">
          </div>
          </form>
          <div>
          <form id="add-sc" action="add-another-sc-teacher.php?id=<?php echo $teacher_id;?>" method="POST">
            <input type="submit" id="save" value="Add Class or Subject" />
            </form> 
          <form id="delete-all" action="delete-teacher-r.php?id=<?php echo $teacher_id;?>" method="POST">
            <input type="submit" id="delete-btn" value="Delete Teacher">
            </form>  
          </div>
          <div id="modal-overlay">
  <div id="modal-dialog">
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete this teacher?</p>
    <div id="modal-actions">
      <button id="modal-cancel">Cancel</button>
      <button id="modal-confirm">Delete</button>
    </div>
  </div>
</div>
        </div>
        <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th><input type="text" id="search-class" placeholder="Class" class="form-control"></th>
              <th><input type="tel" id="search-subject" placeholder="Subject" class="form-control"></th>
              <th colspan="2">Actions</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php for($i=0;$i<count($records);$i++){ ;?>
            <tr>
             <td><?php echo $records[$i]['class_id'];?></td>
             <td><?php echo $records[$i]['subject_name'];?></td>
             <td>
                <a href="edit-teacher.php? id=<?php echo $records[$i]['teacher_id'];?>&sub=<?php echo $records[$i]['subject_id']; ?>&cls=<?php echo $records[$i]['class_id']; ?>"><button>Edit</button></a>
              </td>
              <td>
              <form id="delete-teacher" action="delete-teacher.php? id=<?php echo $records[$i]['teacher_id'];?>&sub=<?php echo $records[$i]['subject_id']; ?>&cls=<?php echo $records[$i]['class_id']; ?>" method="POST">
                <input type="submit" id="delete-btn" value="delete">
              </form> 
               
              </td>
            </tr>
            <?php };?>

          </tbody>
        </table>
        </div>
        
      </article>
      
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
    <script>
 const searchClassInput = document.getElementById('search-class');
const searchSubjectInput = document.getElementById('search-subject');
const tableBody = document.getElementById('table-body');

function filterTable() {
  const searchClassValue = searchClassInput.value.toLowerCase();
  const searchSubjectValue = searchSubjectInput.value.toLowerCase();
  const rows = tableBody.getElementsByTagName('tr');

  for (let i = 0; i < rows.length; i++) {
    const classColumn = rows[i].getElementsByTagName('td')[0];
    const subjectColumn = rows[i].getElementsByTagName('td')[1];
    const classValue = classColumn.textContent.toLowerCase();
    const subjectValue = subjectColumn.textContent.toLowerCase();

    if (
      classValue.includes(searchClassValue) &&
      subjectValue.includes(searchSubjectValue)
    ) {
      rows[i].style.display = '';
    } else {
      rows[i].style.display = 'none';
    }
  }
}

searchClassInput.addEventListener('input', filterTable);
searchSubjectInput.addEventListener('input', filterTable);
</script>
<div ng-include="'../../views/footer.html'"></div>
  </body>
</html>


<script>
    function deleteTeacher() {
  var form = document.getElementById("delete-all");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));
}

function deleteTeacher() {
  var form = document.getElementById("delete-teacher");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));
}

function confirmDeletion() {
    return confirm("Are you sure you want to delete this teacher?");}

    const deleteForm = document.getElementById('delete-all');
const modalOverlay = document.getElementById('modal-overlay');
const modalCancel = document.getElementById('modal-cancel');
const modalConfirm = document.getElementById('modal-confirm');

deleteForm.addEventListener('submit', function(event) {
  event.preventDefault();
  modalOverlay.style.display = 'flex';
  document.body.classList.add('modal-open');
  toggleBackgroundElements();
});

modalCancel.addEventListener('click', function() {
  closeModal();
});

modalConfirm.addEventListener('click', function() {
  closeModal();
  deleteForm.submit();
});

function closeModal() {
  modalOverlay.style.display = 'none';
  document.body.classList.remove('modal-open');
  toggleBackgroundElements();
}

function toggleBackgroundElements() {
  const backgroundElements = document.querySelectorAll('body > *:not(#modal-overlay)');
  backgroundElements.forEach(element => {
    element.classList.toggle('modal-overlay-hidden');
  });
}

</script>