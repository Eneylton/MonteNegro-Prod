
async function listarServicos(id_cat){
    const dadosProd = await fetch('listar-servicos.php?id_cat=' + id_cat);
    const respostaProd = await dadosProd.json();
  
    const listarServicosModal = new bootstrap.Modal(document.getElementById("listarServicosModal"));
    listarServicosModal.show();
    document.querySelector(".listar-modal2").innerHTML = respostaProd['dados'];
    
 
}


async function listarSetores(id_cat){
    const dadosProd = await fetch('listar-setores.php?id_cat=' + id_cat);
    const respostaProd = await dadosProd.json();
  
    const listarSetorModal = new bootstrap.Modal(document.getElementById("listarSetorModal"));
    listarSetorModal.show();
    document.querySelector(".listar-modal").innerHTML = respostaProd['dados'];
    
 
}



async function editar(id_cat){
    const dadosProd = await fetch('editar-setor.php?id_cat=' + id_cat);
    const respostaProd = await dadosProd.json();
  
    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
    document.querySelector(".editar").innerHTML = respostaProd['dados'];
    
 
}











