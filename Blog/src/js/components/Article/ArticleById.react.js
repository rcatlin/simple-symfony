var React = require('react');
var ReactPropTypes = React.PropTypes;

var Article = require('../article.react');
var ArticleStore = require('../../stores/ArticleStore');


var ArticleById = React.createClass({
    displayName: 'ArticleById',

    propTypes: {
        params: ReactPropTypes.object.isRequired
    },

    getInitialState: function() {
        return {
            articles: undefined // eslint-disable-line no-undefined
        };
    },

    componentDidMount: function() {
        var articleId = parseInt(this.props.params.id, 10);

        ArticleStore.getById(this, articleId);
    },

    render: function() {
        var article = this.state.article;

        if (typeof article === 'undefined') {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        {'Article could not be found.'}
                    </div>
                </div>
            );
        }

        return (
            <Article
                content={article.content}
                createdAt={article.createdAt}
                id={article.id}
                key={article.id}
                slug={article.slug}
                tags={article.tags}
                title={article.title}
            />
        );
    }
});

module.exports = ArticleById;

