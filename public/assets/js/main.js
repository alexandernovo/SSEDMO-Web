$(document).ready(function () {
  function updateState(state) {
    if (state === "closed") {
      $(".text-side").css("display", "none");
      $(".content-visibility").css("display", "block");
      $("#sidebar").removeClass("sidebar").addClass("close-sidebar");
      $("#icon-close").removeClass("fa-angle-left").addClass("fa-angle-right");
      $("#profile-close").removeClass("col-2").addClass("col-8 m-auto");
      $(".icon-center")
        .removeClass("icon-center-open")
        .addClass("icon-center-closed");
      $("#div-close").removeClass("ms-3");
      $("#main-content")
        .removeClass("main-content col-10")
        .addClass("main-content-lg col-12");
    } else {
      $(".text-side").css("display", "block");
      $(".content-visibility").css("display", "block");
      $("#sidebar").removeClass("close-sidebar").addClass("sidebar");
      $("#icon-close").removeClass("fa-angle-right").addClass("fa-angle-left");
      $("#profile-close").removeClass("col-8 m-auto").addClass("col-2");
      $("#div-close").addClass("ms-3");
      $("#main-content")
        .removeClass("main-content-lg col-12")
        .addClass("main-content col-10");
      $(".icon-center")
        .removeClass("icon-center-closed")
        .addClass("icon-center-open");
    }
  }

  $("#close-side").on("click", function () {
    let currentState = $("#sidebar").hasClass("sidebar") ? "open" : "closed";
    let newState = currentState === "open" ? "closed" : "open";
    updateState(newState);
    localStorage.setItem("sidebarState", newState);
  });

  let savedState = localStorage.getItem("sidebarState");

  if (savedState) {
    updateState(savedState);
  } else {
    updateState("open");
    localStorage.setItem("sidebarState", "open");
  }
});

$(document).ready(function () {
  $("#example").DataTable();
});

$(document).ready(function () {
  $("#example1").DataTable();
});

// Save scroll position on beforeunload
window.addEventListener("beforeunload", function () {
  localStorage.setItem("scrollPos", window.pageYOffset);
});

// Restore scroll position on load
window.addEventListener("load", function () {
  setTimeout(function () {
    window.scrollTo(0, localStorage.getItem("scrollPos") || 0);
  }, 0);
});

$(".logout").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    type: "warning",
    icon: "warning",
    title: "Are You Sure?",
    text: "You will be logout",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Logout",
    customClass: {
      actions: "my-actions",
      cancelButton: "order-1 right-gap",
      confirmButton: "order-2",
      container: "my-swal",
    },
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  });
});

$(".activate").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    type: "warning",
    icon: "warning",
    title: "Are You Sure?",
    text: "This user will be Activated",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Activate",
    customClass: {
      actions: "my-actions",
      cancelButton: "order-1 right-gap",
      confirmButton: "order-3",
      container: "my-swal",
    },
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  });
});
$(".deactivate").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    type: "warning",
    icon: "warning",
    title: "Are You Sure?",
    text: "This user will be Deactivated",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Deactivate",
    customClass: {
      actions: "my-actions",
      cancelButton: "order-1 right-gap",
      confirmButton: "order-2",
      container: "my-swal",
    },
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  });
});
function togglePassword(inputId) {
  var input = $("#" + inputId);
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
}

$(document).ready(function () {
  $("#email_check").change(function () {
    if ($(this).is(":checked")) {
      localStorage.setItem("email_check", true);
    } else {
      localStorage.removeItem("email_check");
    }
  });
  $("#user_check").change(function () {
    if ($(this).is(":checked")) {
      localStorage.setItem("user_check", true);
    } else {
      localStorage.removeItem("user_check");
    }
  });
  $("#pass_check").change(function () {
    if ($(this).is(":checked")) {
      localStorage.setItem("pass_check", true);
    } else {
      localStorage.removeItem("pass_check");
    }
  });

  const emailChecked = localStorage.getItem("email_check");
  const userChecked = localStorage.getItem("user_check");
  const passChecked = localStorage.getItem("pass_check");

  if (emailChecked === "true") {
    $("#email_check").prop("checked", true);
  }
  if (userChecked === "true") {
    $("#user_check").prop("checked", true);
  }
  if (passChecked === "true") {
    $("#pass_check").prop("checked", true);
  }
});

$(document).ready(function () {
  // show the loader on page load
  $(".spinner").css("display", "block");
  // hide the spinner after 2 seconds
  setTimeout(function () {
    $(".spinner").css("display", "none");
  }, 1500);
});

$(document).ready(function () {
  $(".login").on("click", function (e) {
    e.preventDefault();
    const button = $(this);
    const form = $("#login-form");
    const spinner = $(
      "<div class='spinner-border text-light me-1' role='status' id='auth' style='height:18px; width:18px;'><span class='visually-hidden'>Loading...</span></div>"
    );

    // Add spinner and text elements inside the button
    button.html("").append(spinner).append("Authenticating...");

    // Submit the form after a 2 second delay
    setTimeout(function () {
      form.submit();
    }, 1300);
  });
});

$(document).ready(function () {
  $(".find").on("click", function (e) {
    e.preventDefault();
    const button = $(this);
    const form = $("#forget-form");
    const spinner = $(
      "<div class='spinner-border text-light me-1' role='status' id='auth' style='height:18px; width:18px;'><span class='visually-hidden'>Loading...</span></div>"
    );

    // Add spinner and text elements inside the button
    button.html("").append(spinner).append("Finding...");

    // Submit the form after a 2 second delay
    setTimeout(function () {
      form.submit();
    }, 1300);
  });
});

$(document).ready(function () {
  $("#role_user").on("change", function () {
    if (this.value === "student") {
      localStorage.setItem("student", true);
      localStorage.setItem("role_user", this.value);
      $("#student_id_form").show();
    } else {
      $("#student_id_form").hide();
      localStorage.setItem("role_user", this.value);
      localStorage.setItem("student", false);
    }
  });
});

$(document).ready(function () {
  const student_check = localStorage.getItem("student");
  const role_user = localStorage.getItem("role_user");
  // If the stored value exists, select the corresponding option
  if (role_user) {
    $("#role_user").val(role_user);
  }
  if (student_check === "true") {
    $("#student_id_form").show();
  } else {
    $("#student_id_form").hide();
  }
});

$(document).ready(function () {
  $("#addbuilding_btn").on("click", function () {
    $("#addbuildingmodal").modal("show");
    localStorage.setItem("addbuildingmodal", true);
  });
  $("#closebuildingmodal").on("click", function () {
    $("#addbuildingmodal").modal("hide");
    localStorage.setItem("addbuildingmodal", false);
  });
  $("#addbuildingmodal").on("hidden.bs.modal", function () {
    localStorage.setItem("addbuildingmodal", false);
  });
});

$(document).ready(function () {
  const addbuilding = localStorage.getItem("addbuildingmodal");
  if (addbuilding === "true") {
    $("#addbuildingmodal").modal("show");
  } else {
    $("#addbuildingmodal").modal("hide");
  }
});

function editbuilding(id) {
  $("#editbuildingmodal" + id).modal("show");
  localStorage.setItem("editbuildingmodal", true);
  localStorage.setItem("modal_edit", "#editbuildingmodal" + id);
  $("#editbuildingmodal" + id).on("hidden.bs.modal", function () {
    localStorage.setItem("editbuildingmodal", false);
  });
}

function closeditbuilding(id) {
  $("#editbuildingmodal" + id).modal("hide");
  localStorage.setItem("editbuildingmodal", false);
}

$(document).ready(function () {
  const editbuilding_show = localStorage.getItem("modal_edit");
  if (editbuilding_show) {
    const id = editbuilding_show.replace("#editbuildingmodal", "");
    const editbuilding = localStorage.getItem("editbuildingmodal");
    if (editbuilding === "true") {
      $(editbuilding_show).modal("show");
    } else {
      $(editbuilding_show).modal("hide");
    }
  }
});

$(".delete").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    type: "warning",
    icon: "warning",
    title: "Are You Sure?",
    text: "This will be deleted",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Delete",
    customClass: {
      actions: "my-actions",
      cancelButton: "order-1 right-gap",
      confirmButton: "order-2",
      container: "my-swal",
    },
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  });
});

$(document).ready(function () {
  $("#addroommodal_btn").on("click", function () {
    $("#addroommodal").modal("show");
    localStorage.setItem("addroommodal", true);
  });
  $("#close_room_modal").on("click", function () {
    $("#addroommodal").modal("hide");
    localStorage.setItem("addroommodal", false);
  });
  $("#addroommodal").on("hidden.bs.modal", function () {
    localStorage.setItem("addroommodal", false);
  });
});

$(document).ready(function () {
  const addroom = localStorage.getItem("addroommodal");
  if (addroom === "true") {
    $("#addroommodal").modal("show");
  } else {
    $("#addroommodal").modal("hide");
  }
});

function editroom(id) {
  $("#editroommodal" + id).modal("show");
  localStorage.setItem("editroommodal", true);
  localStorage.setItem("modal_edit_room", "#editroommodal" + id);
  $("#editroommodal" + id).on("hidden.bs.modal", function () {
    localStorage.setItem("editroommodal", false);
  });
}

function closeditroom(id) {
  $("#editroommodal" + id).modal("hide");
  localStorage.setItem("editroommodal", false);
}

$(document).ready(function () {
  const editroom_show = localStorage.getItem("modal_edit_room");
  if (editroom_show) {
    const id = editroom_show.replace("#editroommodal", "");
    const editroom = localStorage.getItem("editroommodal");
    if (editroom === "true") {
      $(editroom_show).modal("show");
    } else {
      $(editroom_show).modal("hide");
    }
  }
});

//add Colleges
$(document).ready(function () {
  const addColleges = localStorage.getItem("addColleges");
  if (addColleges === "true") {
    $("#addColleges").modal("show");
  } else {
    $("#addColleges").modal("hide");
  }
  $("#add_college").on("click", function () {
    localStorage.setItem("addColleges", true);
    $("#addColleges").on("hidden.bs.modal", function () {
      localStorage.setItem("addColleges", false);
    });
  });

  $("#closeColleges").on("click", function () {
    localStorage.setItem("addColleges", false);
  });
});
//add Courses
$(document).ready(function () {
  const addCourse = localStorage.getItem("addCourse");
  if (addCourse === "true") {
    $("#addCourse").modal("show");
  } else {
    $("#addCourse").modal("hide");
  }
  $("#add_course").on("click", function () {
    localStorage.setItem("addCourse", true);
    $("#addCourse").on("hidden.bs.modal", function () {
      localStorage.setItem("addCourse", false);
    });
  });
  $("#closeCourses").on("click", function () {
    localStorage.setItem("addCourse", false);
  });
});


// $.ajax({
//   url: 'http://localhost/Research Management System/ajax/getTime.php?getTeacher',
//   type: "GET",
//   success: function (response) {
//     response = JSON.parse(response);
//     if (response.status == "success") {
//       var events = [];
//       $.each(response.data, function (i, item) {
//         events.push({
//           id: item.availability_ID,
//           title: item.availability_Status,
//           start: item.availability_startDatetime,
//           end: item.availability_endDatetime,
//           allDay: false
//         });
//       });
//       callback(events);
//     } else {
//       failed('Error getting availability.');
//     }
//   },
//   error: function (xhr, status, error) {
//     // Handle the error
//     failed('Error getting availability.');
//   }
// });