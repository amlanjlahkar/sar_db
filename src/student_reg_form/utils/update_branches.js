// Function to fetch branches based on selected course
function fetchBranches() {
    let courseSelector = document.getElementById("st_course").value

    if (courseSelector == "") return

    let url = "./utils/fetch_branches.php?courseID=" + courseSelector

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            let branchSelector = document.getElementById("st_branch")
            branchSelector.innerHTML = ""
            data.forEach((branch) => {
                let newOpt = document.createElement("option")
                newOpt.value = branch.BranchID
                newOpt.textContent = branch.BranchName
                branchSelector.appendChild(newOpt)
            })
        })
        .catch((err) => console.error("Error fetching branches:", err))
}

document.getElementById("st_course").addEventListener("change", fetchBranches)

fetchBranches()
