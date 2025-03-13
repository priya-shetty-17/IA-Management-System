document.addEventListener("DOMContentLoaded", function () {
    const semesterSelect = document.getElementById("semester");
    const subjectsContainer = document.getElementById("subjectsContainer");

    // Function to show a success message
    function showToast(message) {
        const toast = document.createElement("div");
        toast.className = "toast-message";
        toast.innerText = message;

        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Load departments
    function loadDepartments() {
        fetch("", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ action: "getDepartments" }),
        })
            .then((response) => response.json())
            .then((departments) => {
                document.querySelectorAll(".department-select").forEach((dropdown) => {
                    dropdown.innerHTML =
                        '<option value="">Select Department</option>' +
                        departments.map((dept) => `<option value="${dept.deptid}">${dept.dname}</option>`).join("");
                });
            })
            .catch((error) => console.error("Error loading departments:", error));
    }

    // Load subjects based on semester
    semesterSelect.addEventListener("change", function () {
        const semester = semesterSelect.value;

        fetch("", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ action: "getSubjects", semester }),
        })
            .then((response) => response.json())
            .then((subjects) => {
                subjectsContainer.innerHTML = subjects.length
                    ? createSubjectsTable(subjects)
                    : "<p>No subjects found for the selected semester.</p>";

                loadDepartments(); // Load departments after subjects are displayed
                addDepartmentChangeListeners(); // Attach listeners to department dropdowns
            })
            .catch((error) => console.error("Error loading subjects:", error));
    });

    // Create subjects table
    function createSubjectsTable(subjects) {
        return `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Department</th>
                        <th>Faculty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${subjects
                        .map(
                            (subject) => `
                            <tr ${subject.assigned ? 'class="table-success"' : ''}>
                                <td>${subject.name}</td>
                                <td>${subject.code}</td>
                                <td>
                                    <select class="form-select department-select" data-subid="${subject.subid}" ${subject.assigned ? 'disabled' : ''}>
                                        <option value="">Select Department</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select faculty-select" data-subid="${subject.subid}" ${subject.assigned ? 'disabled' : ''}>
                                        <option value="">Select Faculty</option>
                                    </select>
                                </td>
                                <td>
                                    ${subject.assigned ? "" : `<button class="btn btn-primary assign-btn" data-subid="${subject.subid}">Assign</button>`}
                                </td>
                            </tr>
                        `
                        )
                        .join("")}
                </tbody>
            </table>
        `;
    }

    // Add event listeners for department dropdown changes
    function addDepartmentChangeListeners() {
        document.addEventListener("change", (event) => {
            if (event.target.classList.contains("department-select")) {
                const subid = event.target.dataset.subid;
                const deptid = event.target.value;
                const facultySelect = document.querySelector(`.faculty-select[data-subid="${subid}"]`);
    
                if (!deptid) {
                    facultySelect.innerHTML = '<option value="">Select Faculty</option>';
                    facultySelect.disabled = true;
                    return;
                }
    
                fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ action: "getFaculties", deptid }),
                })
                    .then((response) => response.json())
                    .then((faculties) => {
                        if (faculties.error) {
                            facultySelect.innerHTML = `<option value="">${faculties.error}</option>`;
                        } else {
                            facultySelect.innerHTML =
                                '<option value="">Select Faculty</option>' +
                                faculties.map((fac) => `<option value="${fac.facid}">${fac.fname}</option>`).join("");
                            facultySelect.disabled = false;
                        }
                    })
                    .catch((error) => {
                        console.error("Error loading faculties:", error);
                        facultySelect.innerHTML = '<option value="">Error loading faculties</option>';
                    });
            }
        });
    }    

    // Handle click events for Assign button
    document.addEventListener("click", async (event) => {
        if (event.target.classList.contains("assign-btn")) {
            const subid = event.target.dataset.subid;
            const facultySelect = document.querySelector(`.faculty-select[data-subid="${subid}"]`);
            const facid = facultySelect ? facultySelect.value : null;
        
            if (!facid) {
                showToast("Please select a faculty before assigning.");
                return;
            }
        
            fetch("", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    action: "assignFaculty",
                    subid: subid,
                    facid: facid,
                }),
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.success) {
                        showToast("Subject assigned successfully!");
                        const row = document.querySelector(`.assign-btn[data-subid="${subid}"]`).closest("tr");
                        row.classList.add("table-success");
                        row.querySelector(".assign-btn").remove();
                    } else {
                        showToast(result.message || "Failed to assign subject.");
                    }
                })
                .catch((error) => {
                    console.error("Error assigning faculty:", error);
                    showToast("An error occurred while assigning the subject.");
                });
        }
    });
});
