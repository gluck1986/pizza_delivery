import React from 'react';
import ReactDOM from 'react-dom';


const App: React.FC = () => {
    return (
        <div>
            Hello World
        </div>
    )
}


if (document.getElementById('root')) {
    ReactDOM.render(<App />, document.getElementById('root'));
}
