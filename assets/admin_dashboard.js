console.log("Admin js script loaded");
// DOM Elements
var newMemberAddBtn = document.querySelector('.addMemberBtn'),
darkBg = document.querySelector('.dark_bg'),
popupForm = document.querySelector('.popup'),
crossBtn = document.querySelector('.closeBtn'),
submitBtn = document.querySelector('.submitBtn'),
modalTitle = document.querySelector('.modalTitle'),
popupFooter = document.querySelector('.popupFooter'),
imgInput = document.querySelector('.img'),
imgHolder = document.querySelector('.imgholder'),
form = document.querySelector('form'),
formInputFields = document.querySelectorAll('form input'),
uploadimg = document.querySelector("#uploading"),
fName = document.getElementById("fname"),
lName = document.getElementById("lname"),
username = document.getElementById("username"),
password = document.getElementById("password"),
email = document.getElementById("email"),
phone = document.getElementById("mobile"),
gender = document.getElementById("gender"),
dob = document.getElementById("dob"),
profession = document.getElementById("profession"),
entries = document.querySelector(".showEntries"),
tabSize = document.getElementById("table_size"),
userInfo = document.querySelector(".userInfo"),
table = document.querySelector("table"),
filterData = document.getElementById("search");

let allUsers = [];
let filteredUsers = [];
let isEdit = false, editId = null;
var arrayLength = 0;
var tableSize = 10;
var startIndex = 1;
var endIndex = 0;
var currentIndex = 1;
var maxIndex = 0;

// Fetch all users from PHP backend
async function fetchUsers() {
    const res = await fetch('../model/get_users.php');
    allUsers = await res.json();
    console.log(allUsers); // Debugging
    filteredUsers = [...allUsers];
    displayIndexBtn();
}

// Add user via PHP
async function addUser(user) {
    try {
        console.log("Payload sent to ../model/add_user.php:", user); // Debugging
        const res = await fetch('../model/add_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(user),
        });
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        const response = await res.json();
        console.log("Response from ../model/add_user.php:", response); // Debugging
        if (response.message === "User added successfully") {
            await fetchUsers(); // Refresh the user list
        } else {
            console.error("Add failed:", response);
        }
    } catch (error) {
        console.error('Error adding user:', error);
    }
}


//uploading image
uploadimg.onchange = async function() {
    if (uploadimg.files[0].size < 1000000) {
        const formData = new FormData();
        formData.append('image', uploadimg.files[0]);
        const res = await fetch('../model/upload_image.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            imgInput.src = data.path; // Show the uploaded image
            imgInput.setAttribute('data-path', data.path); // Store the path for later
        } else {
            alert(data.error);
        }
    } else {
        alert("This file is too large!");
    }
};



// Update user via PHP
async function updateUser(user) {
    try {
        const res = await fetch('../model/update_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(user),
        });
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        const response = await res.json();
        console.log("Update response:", response); // Debugging
        if (response.success) {
            await fetchUsers(); // Refresh the user list
        } else {
            console.error("Update failed:", response.error);
        }
    } catch (error) {
        console.error('Error updating user:', error);
    }
}
// Delete user via PHP
async function deleteUser(id) {
    await fetch('../model/delete_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id: id})
    });
    await fetchUsers();
}

// Image upload (base64)
uploadimg.onchange = function(){
    if(uploadimg.files[0].size < 1000000){
        var fileReader = new FileReader();
        fileReader.onload = function(e){
            var imgUrl = e.target.result;
            imgInput.src = imgUrl;
        }
        fileReader.readAsDataURL(uploadimg.files[0]);
    } else {
        alert("This file is too large!");
    }
}

// Pagination calculations
function preLoadCalculations(){
    arrayLength = filteredUsers.length;
    maxIndex = Math.ceil(arrayLength / tableSize);
}

// Display pagination buttons
function displayIndexBtn(){
    preLoadCalculations();
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = "";
    pagination.innerHTML = '<button onclick="prev()" class="prev">Previous</button>';
    for(let i=1; i<=maxIndex; i++){
        pagination.innerHTML += `<button onclick="paginationBtn(${i})" index="${i}">${i}</button>`;
    }
    pagination.innerHTML += '<button onclick="next()" class="next">Next</button>';
    highlightIndexBtn();
}

// Highlight current page
function highlightIndexBtn(){
    startIndex = ((currentIndex - 1) * tableSize) + 1;
    endIndex = (startIndex + tableSize) - 1;
    if(endIndex > arrayLength) endIndex = arrayLength;
    if(maxIndex >= 2){
        var nextBtn = document.querySelector(".next");
        nextBtn.classList.add("act");
    }
    entries.textContent = `Showing ${startIndex} to ${endIndex} of ${arrayLength} entries`;
    var paginationBtns = document.querySelectorAll('.pagination button');
    paginationBtns.forEach(btn => {
        btn.classList.remove('active');
        if(btn.getAttribute('index') === currentIndex.toString()){
            btn.classList.add('active');
        }
    });
    showInfo();
}

// Render users in table
function showInfo() {
    userInfo.innerHTML = "";
    var tab_start = startIndex - 1;
    var tab_end = endIndex;
    if (filteredUsers.length > 0) {
        for (var i = tab_start; i < tab_end; i++) {
            var staff = filteredUsers[i];
            if (staff) {
                let createElement = `<tr>
                <td>${i + 1}</td>
                <td>${staff.user_type}</td>
                <td><img src="${staff.profile_picture || './images/user.png'}" alt="Profile Picture" width="20" height="20"></td>
                <td>${staff.first_name}</td>
                <td>${staff.last_name}</td>
                <td>${staff.dob || 'N/A'}</td> <!-- Use dob instead of age -->
                <td>${staff.gender}</td>
                <td>${staff.email}</td>
                <td>${staff.phone}</td>
                <td>${staff.profession}</td>
                <td>${staff.username}</td>
                <td>${staff.password}</td>
                <td>${staff.registration_time}</td>
                <td>
                    <button onclick="readInfo('${encodeURIComponent(staff.profile_picture || './images/user.png')}', '${encodeURIComponent(staff.first_name)}', '${encodeURIComponent(staff.last_name)}', '${staff.dob}', '${staff.gender}', '${encodeURIComponent(staff.email)}', '${encodeURIComponent(staff.phone)}', '${encodeURIComponent(staff.profession)}', '${encodeURIComponent(staff.username)}', '${encodeURIComponent(staff.password)}', '${staff.registration_time}', '${staff.user_type}')"><i class="fa-regular fa-eye"></i></button>
                    <button onclick="editInfo('${staff.id}', '${encodeURIComponent(staff.profile_picture || './images/user.png')}', '${encodeURIComponent(staff.first_name)}', '${encodeURIComponent(staff.last_name)}', '${staff.dob}', '${staff.gender}', '${encodeURIComponent(staff.email)}', '${encodeURIComponent(staff.phone)}', '${encodeURIComponent(staff.profession)}', '${encodeURIComponent(staff.username)}', '${encodeURIComponent(staff.password)}', '${staff.registration_time}', '${staff.user_type}')"><i class="fa-regular fa-pen-to-square"></i></button>
                    <button onclick="deleteInfo('${staff.id}')"><i class="fa-regular fa-trash-can"></i></button>
                </td>
            </tr>`;
                userInfo.innerHTML += createElement;
            }
        }
    } else {
        userInfo.innerHTML = `<tr><td colspan="13" align="center">No data available in table</td></tr>`;
    }
}

// Show user details (read-only)
window.readInfo = function(pic, fname, lname, dob, Gender, Email, Phone, Profession, Username, Password, SDate, UserType) {
    console.log("View button clicked");
    console.log("DOB:", dob); // Debugging
    imgInput.src = decodeURIComponent(pic) || "./images/user.png";
    fName.value = decodeURIComponent(fname);
    lName.value = decodeURIComponent(lname);
    dob.value = dob || ""; // Assign dob directly to the input field
    gender.value = Gender || "N/A";
    email.value = decodeURIComponent(Email);
    phone.value = decodeURIComponent(Phone);
    profession.value = decodeURIComponent(Profession);
    username.value = decodeURIComponent(Username);
    password.value = decodeURIComponent(Password); // Show hashed password
    type.value = UserType || "N/A"; // Display user type
    darkBg.classList.add('active');
    popupForm.classList.add('active');
    popupFooter.style.display = "none";
    modalTitle.innerHTML = "Profile";
    formInputFields.forEach(input => input.disabled = true);
    imgHolder.style.pointerEvents = "none";
};

window.editInfo = function(id, pic, fname, lname, dob, Gender, Email, Phone, Profession, Username, Password, SDate, UserType) {
    isEdit = true;
    editId = id;
    console.log("Edit button clicked");
    console.log("DOB:", dob); // Debugging
    imgInput.src = decodeURIComponent(pic) || "./images/user.png";
    fName.value = decodeURIComponent(fname);
    lName.value = decodeURIComponent(lname);
    dob.value = dob || ""; // Assign dob directly to the input field
    gender.value = Gender || "N/A";
    email.value = decodeURIComponent(Email);
    phone.value = decodeURIComponent(Phone);
    profession.value = decodeURIComponent(Profession);
    username.value = decodeURIComponent(Username);
    password.value = decodeURIComponent(Password); // Show hashed password
    type.value = UserType || "N/A"; // Display user type
    darkBg.classList.add('active');
    popupForm.classList.add('active');
    popupFooter.style.display = "block";
    modalTitle.innerHTML = "Update the Form";
    submitBtn.innerHTML = "Update";
    formInputFields.forEach(input => input.disabled = false);
    imgHolder.style.pointerEvents = "auto";
};

// Delete user
window.deleteInfo = function(id){
    if(confirm("Are you sure want to delete?")){
        deleteUser(id);
    }
}

// Show add user form
newMemberAddBtn.addEventListener('click', ()=> {
    isEdit = false;
    editId = null;
    submitBtn.innerHTML = "Submit";
    modalTitle.innerHTML = "Fill the Form";
    popupFooter.style.display = "block";
    imgInput.src = "./images/user.png";
    darkBg.classList.add('active');
    popupForm.classList.add('active');
    form.reset();
    formInputFields.forEach(input => { input.disabled = false; });
    imgHolder.style.pointerEvents = "auto";
});

// Close popup
crossBtn.addEventListener('click', ()=>{
    darkBg.classList.remove('active');
    popupForm.classList.remove('active');
    form.reset();
});

// Handle form submit (add or update)
// ...existing code...
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const now = new Date();
    const pad = n => n.toString().padStart(2, '0');
    const registration_time = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    const user = {
        id: editId, // Include the user ID for updating
        profile_picture: imgInput.getAttribute('data-path') || "./images/user.png",
        first_name: fName.value,
        last_name: lName.value,
        dob: dob.value,
        gender: gender.value,
        email: email.value,
        phone: phone.value,
        profession: profession.value,
        username: username.value,
        password: password.value,
        user_type: type.value,
        registration_time // <-- Add this line
    };

    if (!isEdit) {
        console.log("Adding user:", user); // Debugging
        await addUser(user);
    } else {
        console.log("Updating user:", user); // Debugging
        await updateUser(user);
    }

    submitBtn.innerHTML = "Submit";
    modalTitle.innerHTML = "Fill the Form";
    darkBg.classList.remove('active');
    popupForm.classList.remove('active');
    form.reset();
    isEdit = false;
    editId = null;
    currentIndex = 1;
    startIndex = 1;
    displayIndexBtn();
});
// ...existing code...

// Pagination controls
window.next = function(){
    var prevBtn = document.querySelector('.prev');
    var nextBtn = document.querySelector('.next');
    if(currentIndex <= maxIndex - 1){
        currentIndex++;
        prevBtn.classList.add("act");
        highlightIndexBtn();
    }
    if(currentIndex > maxIndex - 1){
        nextBtn.classList.remove("act");
    }
}
window.prev = function(){
    var prevBtn = document.querySelector('.prev');
    if(currentIndex > 1){
        currentIndex--;
        prevBtn.classList.add("act");
        highlightIndexBtn();
    }
    if(currentIndex < 2){
        prevBtn.classList.remove("act");
    }
}
window.paginationBtn = function(i){
    currentIndex = i;
    var prevBtn = document.querySelector('.prev');
    var nextBtn = document.querySelector('.next');
    highlightIndexBtn();
    if(currentIndex > maxIndex - 1){
        nextBtn.classList.remove('act');
    } else {
        nextBtn.classList.add("act");
    }
    if(currentIndex > 1){
        prevBtn.classList.add("act");
    }
    if(currentIndex < 2){
        prevBtn.classList.remove("act");
    }
}

// Table size change
tabSize.addEventListener('change', ()=>{
    var selectedValue = parseInt(tabSize.value);
    tableSize = selectedValue;
    currentIndex = 1;
    startIndex = 1;
    displayIndexBtn();
});

// Search/filter
filterData.addEventListener("input", ()=>{
    const searchTerm = filterData.value.toLowerCase().trim();
    if(searchTerm !== ""){
        filteredUsers = allUsers.filter((item) => {
            const fullName = (item.fName + " " + item.lName).toLowerCase();
            const profession = item.profession.toLowerCase();
            const username = item.username.toLowerCase();
            return(
                fullName.includes(searchTerm) ||
                profession.includes(searchTerm) ||
                username.includes(searchTerm)
            );
        });
    } else {
        filteredUsers = [...allUsers];
    }
    currentIndex = 1;
    startIndex = 1;
    displayIndexBtn();
});

// Initial load
fetchUsers();




// Fetch and display complaints
// Fetch and display complaints
async function fetchComplaints() {
    const res = await fetch('../model/get_complaints.php');
    const complaints = await res.json();
    const tbody = document.getElementById('complaintTableBody');
    tbody.innerHTML = '';
    complaints.forEach(c => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${c.name}</td>
            <td>${c.type}</td>
            <td>${c.message}</td>
            <td>${c.posted_date}</td>
        `;
        tbody.appendChild(tr);
    });
}

// Delete complaints from last N days
// document.getElementById('deleteComplaintsBtn').onclick = async function() {
//     const days = parseInt(document.getElementById('deleteDays').value);
//     if (isNaN(days) || days < 1) {
//         alert('Please enter a valid number of days.');
//         return;
//     }
//     if (!confirm(`Delete all complaints from the last ${days} days?`)) return;
//     const res = await fetch('../model/delete_complaints.php', {
//         method: 'POST',
//         headers: {'Content-Type': 'application/json'},
//         body: JSON.stringify({days})
//     });
//     const result = await res.json();
//     alert(result.message || result.error);
//     fetchComplaints();
// };
const deleteComplaintsBtn = document.getElementById('deleteComplaintsBtn');
if (deleteComplaintsBtn) {
    deleteComplaintsBtn.onclick = async function() {
        const days = parseInt(document.getElementById('deleteDays').value);
        if (isNaN(days) || days < 1) {
            alert('Please enter a valid number of days.');
            return;
        }
        if (!confirm(`Delete all complaints from the last ${days} days?`)) return;
        const res = await fetch('../model/delete_complaints.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({days})
        });
        const result = await res.json();
        alert(result.message || result.error);
        fetchComplaints();
    };
}

// Optionally, call fetchComplaints when the section is shown
document.addEventListener('DOMContentLoaded', fetchComplaints);


// SIDEBAR TOGGLE
let sidebarOpen = false;
const sidebar = document.getElementById('sidebar');

function openSidebar() {
    if (!sidebarOpen) {
        sidebar.classList.add('sidebar-responsive');
        sidebarOpen = true;
    }
}

function closeSidebar() {
    if (sidebarOpen) {
        sidebar.classList.remove('sidebar-responsive');
        sidebarOpen = false;
    }
}

// Section Toggle
const sidebarLinks = document.querySelectorAll('.sidebar-list-item a'); // Fix: Select sidebar links
const sections = {
    dashboard: document.getElementById('dashboard-section'),
    user: document.getElementById('user-section'),
    complaint: document.getElementById('complaint-section'),
    settings: document.getElementById('settings-section')
};

sidebarLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        sidebarLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        const section = this.getAttribute('data-section');

        // Hide all sections
        Object.values(sections).forEach(sec => sec.style.display = 'none');

        // Show the selected section
        if (sections[section]) {
            sections[section].style.display = 'block';

            // Initialize CRUD functionality for the User Section
            if (section === 'user') {
                showInfo(); // Call the CRUD function to display user data
            }
        }
    });
});

// Charts
const barChartOptions = {
    series: [
        {
            data: [10, 8, 6, 4, 2],
        },
    ],
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: false,
        },
    },
    colors: ['#246dec', '#cc3c43', '#367952', '#f5b74f', '#4f35a1'],
    plotOptions: {
        bar: {
            distributed: true,
            borderRadius: 4,
            horizontal: false,
            columnWidth: '40%',
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Jun'],
    },
    yaxis: {
        title: {
            text: 'Count',
        },
    },
};

const barChart = new ApexCharts(
    document.querySelector('#bar-chart'),
    barChartOptions
);
barChart.render();

const areaChartOptions = {
    series: [
        {
            name: 'Male User',
            data: [31, 40, 28, 51, 42, 109, 100],
        },
        {
            name: 'Female User',
            data: [11, 32, 45, 32, 34, 52, 41],
        },
    ],
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
            show: false,
        },
    },
    colors: ['#4f35a1', '#246dec'],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
    },
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    markers: {
        size: 0,
    },
    yaxis: [
        {
            title: {
                text: 'Male User',
            },
        },
        {
            opposite: true,
            title: {
                text: 'Female User',
            },
        },
    ],
    tooltip: {
        shared: true,
        intersect: false,
    },
};

const areaChart = new ApexCharts(
    document.querySelector('#area-chart'),
    areaChartOptions
);
areaChart.render();