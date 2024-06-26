<div>

   
<!-- Botão para abrir o modal -->
<button id="openModalBtnBook" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Novo Livro</button>

<!-- Modal -->
<div id="myModalBook" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-50  justify-center items-center">
    <div class="modal-content bg-white p-4 rounded shadow-md">
        <button id="closeModalBtnBook" class="float-right text-red-500 hover:text-red-700 font-bold">Fechar</button>
        <form action="{{ route('adicionarlivro') }}" method="post">
            @csrf
            <input type="text" name="nomelivro" id="bookInput" placeholder="Digite o Livro">
           <br>
           <br>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Adicionar</button>
        </form>
    </div>
</div>

    <br>
    <div id="displayDiv" class="text-yellow">
    </div>
   
    <div class="grid grid-cols-1 md:grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
        @foreach ($nomesLivros as $item)
            @if (trim($item) !== '')
                <div class="bg-indigo-700 rounded-sm shadow-md p-4">
                    <h4 class="text-lg text-white font-semibold mb-2"><a href="{{ route('capitulo', ['capitulo' => $item]) }}">{{$item}}</a></h4>
                    <div class="flex flex-col sm:flex-row justify-center sm:justify-start space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
                        <a href="{{ route('capitulo', ['capitulo' => $item]) }}" 
                            class="bg-indigo-400 
                            hover:bg-indigo-500 py-2 px-4 text-white rounded-md">Capitulos</a> 
                       
                        <button class="bg-yellow-500 hover:bg-yellow-600 py-2 px-4 text-white rounded-md" data-key="{{$item}}">Editar</button>
                        <a href="{{ route('gerapdf', ["nomelivro" => $item]) }}" class="bg-green-500 hover:bg-green-600 
                            py-2 px-4 text-white rounded-md">PDF</a>
                       
                      <button class="btnDelete bg-red-400 hover:bg-red-500 py-2 px-4 text-white rounded-md" id="{{$item}}">Excluir</button>
                    </div>
                </div>
               
            @endif
        @endforeach
    </div>
    
</div>



<!-- Modal Background -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Editar Livro</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="bookName" class="block text-gray-700">Nome do Livro</label>
                <input type="text" id="bookName" name="bookName" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="bg-gray-500 text-white p-2 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-indigo-600 text-white p-2 rounded">Salvar</button>
            </div>
        </form>
    </div>
</div>


<!---modal click excluir-->

<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Excluir Livro</h2>
        <p class="mb-4">Tem certeza de que deseja excluir este livro?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end">
                <button type="button" id="closeDeleteModal" class="bg-gray-500 text-white p-2 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-red-600 text-white p-2 rounded">Excluir</button>
            </div>
        </form>
    </div>



<script>
  

    /// click modal 



    document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('button[data-key]');
    const modal = document.getElementById('editModal');
    const closeModalButton = document.getElementById('closeModal');
    const bookNameInput = document.getElementById('bookName');
    const editForm = document.getElementById('editForm');
    console.log(bookNameInput);
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bookName = this.getAttribute('data-key');
            bookNameInput.value = bookName;
            editForm.action = `/dashboard/editarlivro/${bookName}`;
            modal.classList.remove('hidden');
            modal.classList.add("flex");
        });
    });

    closeModalButton.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove("flex")
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    });
});


 /// modal novo livro 

 const openModalBtnBook = document.getElementById('openModalBtnBook');
    const closeModalBtnBook = document.getElementById('closeModalBtnBook');
    const modalBook = document.getElementById('myModalBook');

    openModalBtnBook.addEventListener('click', () => {
        modalBook.classList.remove('hidden');
        modalBook.classList.add("flex");
    });

    closeModalBtnBook.addEventListener('click', () => {
        modalBook.classList.add('hidden');
        modalBook.classList.remove("flex");
    });

 /// modal excluir 
   
 document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btnDelete');
    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModalButton = document.getElementById('closeDeleteModal');
    const deleteForm = document.getElementById('deleteForm');

    deleteButtons.forEach(deletebtn => {
        deletebtn.addEventListener('click', function (event) {
            const bookId = event.target.id.replace('buttonexcluir-', '');
           
             deleteForm.action = `/dashboard/deletar${bookId}`;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        });
    });

    closeDeleteModalButton.addEventListener('click', function () {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    });

    window.addEventListener('click', function (event) {
        if (event.target == deleteModal) {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }
    });
});

</script>