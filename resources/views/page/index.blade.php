@extends('layouts.master')

@section('header')
    @parent
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
    @foreach( $comments AS $comment )
    <div class="depth{{ $comment['depth'] }} parent{{ $comment['parent_id'] }}" id="comment_{{ $comment['id'] }}" >
      {{ $comment['name'] }} - Posted {{ $comment['created_at'] }}
      <br>
      {{ $comment['comment']}}
      @if( $comment['depth'] < 4 )
        <div>
          <button type="submit" class="btn btn-primary show-form" data-depth="{{ ( $comment['depth'] + 1 ) }}" data-parent="{{ $comment['id'] }}" data-title="Reply to {{ $comment['name'] }}">Reply</button>
        </div>
      @endif
    </div>
    @endforeach


      <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header"><span id="formTitle">Start A New Comment</span></div>
              <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" id="commentForm">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="parent_id" id="parentId" value="">
                  <input type="hidden" name="depth" id="depthValue" value="1">

                  <div class="form-group">
                    <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                      <input type="name" class="form-control" name="name"
                             value="" autofocus>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-4 control-label">Comment</label>
                    <div class="col-md-6">
                      <textarea class="form-control" name="comment" placeholder="Enter your comment here." rows="10"></textarea>
                    </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="postFormData">Post Comment</button>
            </div>
          </div>
        </div>
      </div>


      <div>
        <a href="" class="btn btn-primary show-form" data-depth="1" data-parent="0" data-title="New Comment">New Comment</a>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '.show-form', function( e ){
      e.preventDefault();

      $('#formTitle').html( $(this).attr('data-title') );
      $('#parentId').val( $(this).attr('data-parent') );
      $('#depthValue').val( $(this).attr('data-depth') );

      $("#myModal").modal('show');
  });

  $('#postFormData').on( 'click', function( e ){
    e.preventDefault();

    var parentId = $('#parentId').val();

    $.ajax({
      url: '/api',
      type: 'POST',
      data: $('#commentForm').serialize(),
      success: function( response ){
        if( typeof( response.status ) != 'error' )
        {
            $("#myModal").modal('hide');
            $('.parent'+parentId+':last').after('<div class="depth'+response.data.depth+' parent'+response.data.parent_id+'" id="comment_'+response.data.id+'"> '+response.data.name+' - Posted '+response.data.created_at+' <br> '+response.data.comment+' '+( response.data.depth < 4 ? '<div><button type="submit" class="btn btn-primary show-form" data-depth="'+ ( parseInt(response.data.depth) + 1 )+'" data-parent="'+response.data.id+'" data-title="Reply to '+response.data.name+'">Reply</button></div>' : '' ) + '</div>');
        }
        else
        {
          alert( response.message );
        }
      },
      error: function( xhr, status, error ){

        if( xhr.status == 422 )
        {
          alert( 'Post Failed. Please try Again.' );
        }
      }
    })
  })
});
  
</script>
@stop
