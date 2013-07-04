$(function(){
    var $editor = $('<input type="text" id="editor" />');

    $(document).on('ajaxError', function(e, xhr, options, error){
        alert(xhr.responseText);
    });

    // update task status
    $('.task input[type=checkbox]').click(function(e){
        var $checkbox = $(e.currentTarget);
        var $task = $checkbox.parent('.task');
        var completed = $checkbox.is(':checked') ? 1 : 0;
        var id = $task.attr('data-id');
        var data = {
            completed: completed
        };

        Task.update(id, data, function(){
            $task.toggleClass('completed');
        });
    });

    // update task title
    $('.task .title').on('dblclick', function(e){
        var $title = $(e.currentTarget);
        var $task = $title.parent('.task');
        var id = $task.attr('data-id');
        var title = $task.attr('data-title');

        $title.hide();
        $title.after($editor);
        $editor.val(title);
        $editor.focus();

        $editor.keypress(function(e){
            if(e.which == 13)
                $editor.blur();
        });

        $editor.blur(function(){
            var newTitle = $editor.val();

            if(newTitle.trim() == '') {
                $editor.remove();
                $title.html(title).show();
                return true;
            }

            $title.html(newTitle).show();
            $task.attr('data-title', newTitle);
            $editor.remove();
            Task.update(id, {title: newTitle});
        });
    });

    $('.task .remove').click(function(e){
        e.preventDefault();
        var $task = $(e.currentTarget).parent('.task');
        var id = $task.attr('data-id');
        
        Task.remove(id, function(){
            $task.animate({marginLeft: '-1000px', opacity: 0}, 'slow', 'linear', function(){
                $task.remove();
            });
        });
    });
});

var Task = {

    update: function(id, data, callback){
        $.ajax({
            type: 'put',
            url: '/tasks/' + id,
            data: data,
            success: callback
        });
    },

    remove: function(id, callback){
        $.ajax({
            type: 'delete',
            url: '/tasks/' + id,
            success: callback
        });
    }

};
