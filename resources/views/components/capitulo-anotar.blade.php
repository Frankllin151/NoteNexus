<div>
  
    <button id="openModalBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Novo Capítulo</button>

<!-- Modal -->
<div id="myModal" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-50  justify-center items-center">
    <div class="modal-content bg-white p-4 rounded shadow-md">
        <button id="closeModalBtn" class="float-right text-red-500 hover:text-red-700 font-bold">Fechar</button>
        <form action="{{ route('anotarcapitulo') }}" method="post">
            @csrf
            <input type="hidden" name="nomelivro" value="{{ $capitulo }}">
            <input type="text" name="capitulo" id="CapituloInput" placeholder="Digite o Capítulo">
            <br>
            <br>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Adicionar</button>
        </form>
    </div>
</div>
  
    <div id="anotardiv" class="text-yellow">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
        @foreach ($capitulos as $item)
            @if (trim($item) !== '')
                <div class="bg-slate-300 rounded-sm shadow-md p-4">
                    <a href="{{route('trechos', ['trecho' => $item]) }}" class="text-lg font-semibold mb-2">{{$item}}</a>
                    <div class="flex flex-col sm:flex-row justify-center sm:justify-start space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
                        <form action="{{ route('deletarCapitulo', ['id' => $item]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-400 hover:bg-red-500 py-2 px-4 text-white rounded-md w-full sm:w-auto">Excluir</button>
                        </form> 
                        <button data-key="{{$item}}" class="bg-indigo-400 hover:bg-indigo-500 py-2 px-4 text-white rounded-md w-full sm:w-auto">Editar</button>
                        <a href="{{route('trechos', ['trecho' => $item]) }}" class="bg-indigo-400 hover:bg-indigo-500 py-2 px-4 text-white rounded-md">Anotações</a>
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
                <label for="bookName" class="block text-gray-700">Nome do Capitulo</label>
                <input type="text" id="capituloname" name="capituloname" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="bg-gray-500 text-white p-2 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-indigo-600 text-black p-2 rounded">Salvar</button>
            </div>
        </form>
    </div>
</div>





<script>
  



/// click modal 



document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('button[data-key]');
    const modal = document.getElementById('editModal');
    const closeModalButton = document.getElementById('closeModal');
    const capituloNameInput = document.getElementById('capituloname');
    const editForm = document.getElementById('editForm');
   
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bookName = this.getAttribute('data-key');
            capituloNameInput.value = bookName;
            editForm.action = `/dashboard/editarcapitulo/${bookName}`;
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



// modal capitulo novo 


const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('myModal');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add("flex")
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove("flex")
    });

</script>