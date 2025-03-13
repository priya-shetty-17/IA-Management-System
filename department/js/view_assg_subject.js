document.addEventListener("DOMContentLoaded", () => {
    const semesterDropdown = document.getElementById("semesterDropdown");
    const subjectsContainer = document.getElementById("subjectsContainer");

    // Fetch semesters dynamically
    fetch("view_assg_subject.php?action=getSemesters")
        .then((response) => response.json())
        .then((semesters) => {
            semesterDropdown.innerHTML = '<option value="">Select Semester</option>';
            semesters.forEach((semester) => {
                semesterDropdown.innerHTML += `<option value="${semester.semester}">Semester ${semester.semester}</option>`;
            });
        });

// Fetch subjects when a semester is selected
semesterDropdown.addEventListener("change", (e) => {
    const semester = e.target.value;
    if (semester) {
        fetch(`view_assg_subject.php?action=getSubjects&semester=${semester}`)
            .then((response) => response.json())
            .then((subjects) => {
                subjectsContainer.innerHTML = subjects.map((subject) => `
                    <tr ${subject.is_blocked ? 'class="blocked-row"' : ''}>
                        <td>${subject.subject_name}</td>
                        <td>${subject.subject_code}</td>
                        <td>${subject.credit}</td>
                        <td>${subject.faculty_name || "Not Assigned"}</td>
                        <td>${subject.faculty_department || "N/A"}</td>
                        <td>
                            <button class="btn btn-warning view-btn" data-code="${subject.subject_code}" ${subject.is_blocked ? 'disabled' : ''}>View</button>
                            <button class="btn btn-danger unassign-btn" data-code="${subject.subject_code}" ${subject.is_blocked ? 'disabled' : ''}>Unassign</button>
                        </td>
                    </tr>
                `).join("");
            });
    } else {
        subjectsContainer.addEventListener("click", (e) => {
            if (e.target.disabled) {
                alert("This action is not allowed as no faculty is assigned to this subject.");
                return;
            }
        });        
    }
});

    // Handle unassign action
    subjectsContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("unassign-btn")) {
            const subjectCode = e.target.dataset.code;

            if (confirm("Are you sure you want to unassign this subject?")) {
                fetch("view_assg_subject.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ action: "unassign", subject_code: subjectCode }),
                })
                    .then((response) => response.json())
                    .then((result) => {
                        if (result.success) {
                            alert("Successfully Unassigned the Subject");
                            semesterDropdown.dispatchEvent(new Event("change")); // Refresh subjects
                        }
                    });
            }
        }
    });

    // Handle View button action
    subjectsContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("view-btn")) {
            const subjectCode = e.target.dataset.code;

            // Fetch faculty details for the selected subject
            fetch(`view_assg_subject.php?action=viewFaculty&subject_code=${subjectCode}`)
                .then((response) => response.json())
                .then((facultyDetails) => {
                    // Prepare the content for the popup
                    const content = `
                        <div class="popup">
                            <h3>Faculty Details</h3>
                            <p><strong>Name:</strong> ${facultyDetails.fname || "No Faculty Assigned"}</p>
                            <p><strong>Email:</strong> ${facultyDetails.femail || "No Faculty Assigned"}</p>
                            <p><strong>Phone:</strong> ${facultyDetails.fphone || "No Faculty Assigned"}</p>
                            <p><strong>DOB:</strong> ${facultyDetails.fdob || "No Faculty Assigned"}</p>
                            <p><strong>Department:</strong> ${facultyDetails.department_name || "No Faculty Assigned"}</p>
                            <button class="close-btn">Close</button>
                        </div>
                    `;

                    // Create a container for the popup
                    const popupContainer = document.createElement("div");
                    popupContainer.className = "popup-container";
                    popupContainer.innerHTML = content;
                    document.body.appendChild(popupContainer);

                    // Close popup functionality
                    popupContainer.querySelector(".close-btn").addEventListener("click", () => {
                        document.body.removeChild(popupContainer);
                    });
                })
                .catch((error) => console.error("Error fetching faculty details:", error));
        }
    });
});
