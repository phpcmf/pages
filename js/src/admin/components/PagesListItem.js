import Button from 'cmf/common/components/Button';
import Component from 'cmf/common/Component';
import saveSettings from 'cmf/admin/utils/saveSettings';
import listItems from 'cmf/common/helpers/listItems';
import setRouteWithForcedRefresh from 'cmf/common/utils/setRouteWithForcedRefresh';

import EditPageModal from './EditPageModal';

/**
 * ### Props
 *
 * - `page`
 */
export default class PagesListItem extends Component {
  view() {
    const page = this.attrs.page;
    const url = app.site.attribute('baseUrl') + '/pages/' + page.id() + '-' + page.slug();
    const badges = page.badges().toArray();
    return (
      <tr key={page.id()}>
        <th>
          {page.title()}
          {badges.length ? <ul className="badges">{listItems(page.badges().toArray())}</ul> : null}
        </th>
        <td className="Pages-actions">
          <div className="ButtonGroup">
            {Button.component({
              className: 'Button Button--page-edit',
              icon: 'fas fa-pencil-alt',
              onclick: () => app.modal.show(EditPageModal, { page }),
            })}
            {Button.component({
              className: 'Button Button--page-edit',
              icon: 'fas fa-home',
              onclick: this.setAsHomePage.bind(this),
              disabled: app.data.settings['pages_home'] === page.id() && app.data.settings['default_route'] === '/pages/home',
            })}
            {Button.component({
              className: 'Button Button--page-view',
              icon: 'fas fa-eye fa-sm',
              onclick: () => window.open(url, '_blank'),
            })}
            {Button.component({
              className: 'Button Button--danger Button--page-delete',
              icon: 'fas fa-times',
              onclick: this.delete.bind(this),
            })}
          </div>
        </td>
      </tr>
    );
  }

  setAsHomePage() {
    app.alerts.dismiss(this.successAlert);
    if (confirm(app.translator.trans('cmf-pages.admin.edit_page.set_as_home_page_confirmation'))) {
      const page = this.attrs.page;
      saveSettings({
        default_route: '/pages/home',
        pages_home: page.id(),
      })
        .then(() => {
          app.alerts.show({ type: 'success' }, app.translator.trans('cmf-pages.admin.edit_page.set_as_home_page_done'));
        })
        .catch(() => {})
        .then(() => {
          this.loading = false;
          m.redraw();
        });
    }
  }

  delete() {
    if (confirm(app.translator.trans('cmf-pages.admin.edit_page.delete_page_confirmation'))) {
      const page = this.attrs.page;
      page.delete().then(() => {
        setRouteWithForcedRefresh(app.route('extension', { id: 'cmf-pages' }));
      });
    }
  }
}
