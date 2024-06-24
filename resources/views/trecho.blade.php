<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trechos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  <!--componente aqui-->
                  <button id="clickbuttonadicionar" class="bg-indigo-500 hover:bg-indigo-600
                   text-white font-bold py-2 
                   px-4 rounded">Adicionar Trecho</button>
                  <div id="adicionarmy" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-50  justify-center items-center">
                    <div class="modal-content bg-white p-4 rounded shadow-md">
                        <button id="fecharlBtn" class="float-right text-red-500 hover:text-red-700 font-bold">Fechar</button>
                        <form action="{{ route('trechoadd') }}" method="post">
                            @csrf
                            <input type="hidden" name="capitulo" value="{{ $trecho }}">
                            
                            <textarea name="trecho"  cols="30" rows="10"></textarea>
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Adicionar</button>
                        </form>
                    </div>
                </div>



                 
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @if (trim($trechos) !== "")
                        @foreach ($trechos as $item)
                            <div class="bg-slate-300 rounded-sm shadow-md p-4">
                                <p>{{$item}}</p>
                                <div class="flex flex-col sm:flex-row justify-center sm:justify-start space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
                                    <form action="{{ route('deletarTrecho', ['id' => $item]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-400 hover:bg-red-500 py-2 px-4 text-white rounded-md w-full sm:w-auto">Excluir</button>
                                    </form>
                                    <button data-key="{{$item}}" class="bg-indigo-400 hover:bg-indigo-500 py-2 px-4 text-white rounded-md w-full sm:w-auto">Editar</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
              <label for="bookName" class="block text-gray-700">Trecho do Capitulo</label>
             <textarea id="trecho" name="trecho"  cols="30" rows="10"></textarea>
          </div>
          <div class="flex justify-end">
              <button type="button" id="closeModal" class="bg-gray-500 text-white p-2 rounded mr-2">Cancelar</button>
              <button type="submit" class="bg-indigo-600 text-white p-2 rounded">Salvar</button>
          </div>
      </form>
  </div>
</div>

                </div>
              
            </div>
        </div>
    </div>



<script>
  /// click modal 



document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('button[data-key]');
    const modal = document.getElementById('editModal');
    const closeModalButton = document.getElementById('closeModal');
    const trechoNameTextarea = document.getElementById('trecho');
    const editForm = document.getElementById('editForm');
   
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bookName = this.getAttribute('data-key');
            trechoNameTextarea.value = bookName;
            editForm.action = `/dashboard/editartrecho/${bookName}`;
            modal.classList.remove('hidden');
            
        });
    });

    closeModalButton.addEventListener('click', function () {
        modal.classList.add('hidden');
       
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    });
});


/// modal form 
const openModalBtn = document.getElementById('clickbuttonadicionar');
    const closeModalBtn = document.getElementById('fecharlBtn');
    const modal = document.getElementById('adicionarmy');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add("flex");
        
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove("flex");
    });
</script>
</x-app-layout>
