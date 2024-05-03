// Function to fetch branches based on selected course
function fetchBranches() {
    let courseID = document.getElementById("cid").value

    let url = "./utils/fetch_branches.php?courseID=" + courseID

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            // Populate the branch select options
            let selBranch = document.getElementById("bid")
            selBranch.innerHTML = ""
            data.forEach((branch) => {
                let opt = document.createElement("option")
                opt.value = branch.BranchID
                opt.textContent = branch.BranchName
                selBranch.appendChild(opt)
            })
        })
        .catch((err) => console.error("Error fetching branches:", err))
}

document.getElementById("cid").addEventListener("change", fetchBranches)
fetchBranches()
