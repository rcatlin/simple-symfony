'use strict';

var React = require('react');
var ReactPropTypes = React.PropTypes;

var Item = React.createClass({
    propTypes: {
        active: ReactPropTypes.bool,
        href: ReactPropTypes.string,
        icon: ReactPropTypes.string.isRequired,
        name: ReactPropTypes.string.isRequired,
        onItemClick: ReactPropTypes.func,
        text: ReactPropTypes.string.isRequired
    },

    /**
     * @return {object}
     */
    getDefaultProps: function() {
        return {
            active: false,
            href: '#'
        };
    },

    onClick: function() {
        this.props.onItemClick(this.props.name);
    },

    render: function() {
        var iconClass = 'fa fa-' + this.props.icon;

        return (
            <li className={this.props.active ? 'active' : ''}>
                <a className={iconClass}
                    href='#'
                    name={this.props.name}
                    onClick={this.onClick}>
                    &nbsp;{this.props.text}
                </a>
            </li>
        );
    }
});

module.exports = Item;