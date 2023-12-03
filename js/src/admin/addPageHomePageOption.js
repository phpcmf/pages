import { extend } from 'cmf/common/extend';
import BasicsPage from 'cmf/admin/components/BasicsPage';

export default function () {
  extend(BasicsPage.prototype, 'homePageItems', (items) => {
    items.add('cmf-pages', {
      path: '/pages/home',
      label: 'CMF Pages',
    });
  });
}
